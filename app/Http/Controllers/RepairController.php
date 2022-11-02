<?php

namespace App\Http\Controllers;

use App\Http\Requests\RepairOrderPostRequest;
use App\Models\Auditlog;
use App\Models\CarModel;
use App\Models\Color;
use App\Models\Province;
use App\Models\RepairOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class RepairController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $me = Auth::user();
        $search = $request->search;
        $complete = $request->has('complete');

        if($me->isAdmin())
        {
            $repairOrders = RepairOrder::FilterRegistration($request->search);
        }
        else
        {
            $repairOrders = RepairOrder::InBranch($me->branch_id)->FilterRegistration($request->search);
        }

        $arrayQuery = ['search' => request('search')];
        if ($complete) {
            $repairOrders = $repairOrders->completeOrder();
            $arrayQuery['complete'] = 1;
        } else {
            $repairOrders = $repairOrders->IncompleteOrder();
        }
        $repairOrders = $repairOrders->latest()->paginate(20)->appends($arrayQuery);

        $chart_circle = [RepairOrder::whereNull('returning')->count(), RepairOrder::completeOrder()->count()];
        $chart_line = RepairOrder::getOrderBeforeNow(10);

        return view('repairOrder.index', compact('repairOrders', 'chart_circle', 'chart_line', 'search', 'complete'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $provinces = Province::orderBy('name_th')->get();
        $colors = Color::orderBy('name')->get();
        $models = CarModel::orderBy('name')->get();
        return view('repairOrder.create', compact('provinces','colors', 'models'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RepairOrderPostRequest $request)
    {
        $validate = $request->validated();
        $user = Auth::user();

        $path = null;
        if($request->file())
        {
            $filename = time() . '_' . $request->input('registration') . "." . $request->file('car_image')->extension();
            $path = $this->uploadFile($filename, $request->file('car_image'), "car_picture");
        }

        $order = new RepairOrder();
        $order->car_registration = $request->input('registration');
        $order->province = $request->input('province');
        $order->color = $request->input('color');
        $order->model = $request->input('model');
        $order->vin = $request->input('vin');
        $order->current_distance = $request->input('current_distance');
        $order->latest_distance = $request->input('latest_distance');
        $order->branch_id = $user->branch_id;

        $order->car_received = Carbon::now();

        $order->image_path = $path;

        //bypass for test before login
        $order->user_id = $user->id;

        $order->save();
        Auditlog::log('CREATE',$user->id,'ORDER',$order);
        return redirect()->route('repairOrder.show', ['repairOrder' => $order->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = RepairOrder::findOrFail($id);
        $timeStage = collect([
            0 => ["name" => "รถเข้าศูนย์", "field" => "car_received", "stage" => $order->car_received],
            1 => ["name" => "รอคิว", "field" => "in_queued", "stage" => $order->in_queued],
            2 => ["name" => "กำลังซ่อม", "field" => "repairing", "stage" => $order->repairing],
            3 => ["name" => "ตรวจครั้งสุดท้าย", "field" => "last_check", "stage" => $order->last_check],
            4 => ["name" => "ล้างทำความสะอาด", "field" => "cleaning", "stage" => $order->cleaning],
            5 => ["name" => "พร้อมรับรถ", "field" => "returning", "stage" => $order->returning],
        ]);
        return view('repairOrder.show', ['repairOrder' => $order, 'stages' => $timeStage, 'link' => $this->getApiLink($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = RepairOrder::findOrFail($id);
        $provinces = Province::orderBy('name_th')->get();
        $colors = Color::orderBy('name')->get();
        $models = CarModel::orderBy('name')->get();
        return view('repairOrder.edit', ['repairOrder' => $order], compact('provinces','colors','models'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(RepairOrderPostRequest $request, $id)
    {
        $validate = $request->validated();
        $order = RepairOrder::findOrFail($id);

        $path = $order->image_path;
        if($request->file())
        {
            File::delete(public_path($order->image_path));
            $filename = time() . '_' . $request->input('registration') . "." . $request->file('car_image')->extension();
            $path = $this->uploadFile($filename, $request->file('car_image'), "car_picture");
        }

        $order->car_registration = $request->input('registration');
        $order->province = $request->input('province');
        $order->color = $request->input('color');
        $order->model = $request->input('model');
        $order->vin = $request->input('vin');
        $order->current_distance = $request->input('current_distance');
        $order->latest_distance = $request->input('latest_distance');
        $order->image_path = $path;

        $order->save();
        return redirect()->route('repairOrder.show', ['repairOrder' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy(Request $request , $id)
    {

        $validator = $request->validate([
            'password' => 'required|string'
        ]);

        $user = Auth::user();
        if (!$token = Auth::attempt(['email' => $user->email, 'password' => $request->password])) {
            return Redirect::back()->withErrors(['error' => 'Incorrect password']);
        }
        $order = RepairOrder::findOrFail($id);
        //auth to delete
        $order->delete();
        return redirect()->route('repairOrder.index');
    }

    protected function uploadFile($filename, $file, $dir): string
    {
        $file->storeAs("public/{$dir}", $filename);
        return "/storage/{$dir}/{$filename}";
    }

    private function getApiLink($id): string
    {
        return "https://liff.line.me/" . config("liff.car_register_id") . "?carId={$id}";
    }

    public function updateCheckList(Request $request, $id)
    {
        $request->validate(["key" => "required|array"],
            ["key.required" => "ต้องการ key", "key.array" => "ต้องเป็น array"]);

        $keys = $request->input('key');
        $values = $request->input('value');
        $arr = array_combine($keys, $values);
        $arr = Arr::except($arr, ['']);
        $order = RepairOrder::findOrFail($id);
        $order->repair_list = $arr;
        $order->save();

        return redirect()->route('repairOrder.edit', ['repairOrder' => $id]);
    }
}
