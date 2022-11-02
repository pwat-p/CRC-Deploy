<?php

namespace App\Http\Controllers;

use App\Models\RepairOrder;
use App\Models\Customer;
use App\Models\CarModel;
use App\Models\LineFlexMessage;
use Faker\Extension\ContainerBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use LINE\LINEBot\Exception\InvalidEventRequestException;
use LINE\LINEBot\Exception\InvalidSignatureException;
use LINE\LINEBot\MessageBuilder\FlexMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\MessageBuilder\RawMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;

class LineController extends Controller
{
    public function webhook(Request $request) {
        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(config('line.channel_access_token'));
        $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => config('line.channel_secret')]);

        $signature = $request->header(\LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE);
        if (empty($signature)) {
            abort(400);
        }

        try {
            // get user messages
            $events = $bot->parseEventRequest($request->getContent(), $signature);
        } catch (InvalidSignatureException $e) {
            Log::error('Invalid signature');
            abort(400, 'Invalid signature');
        } catch (InvalidEventRequestException $e) {
            Log::error('Invalid event request');
            abort(400, 'Invalid event request');
        }

        foreach ($events as $event) {
            $inputText = $event->getText();
            if ($inputText === 'My Car') {
                $this->sendRepairStatus($event, $bot);
            }
            if ($inputText === 'สมาชิก') {
                $this->sendProfileMessage($event, $bot);
            }
        }

        return response()->json([]);
    }

    public static function notifyUser(RepairOrder $order) {
        $orderStatus = array();
        $borderStyle = array();
        $lineStyle = array("#B7B7B7","#B7B7B7","#B7B7B7","#B7B7B7","#B7B7B7");

        $orderStatus['name'] = Customer::findorfail($order['customer_id'])['name'];
        $orderStatus['model'] = $order['model'];
        $orderStatus['model_image'] = CarModel::where('name', '=', $order['model'])->value('model_image');
        $orderStatus['car_registration'] = $order['car_registration'];
        $orderStatus['vin'] = $order['vin'];
        $lui = Customer::findorfail($order['customer_id'])['line_id'];

        $statusList = array('car_received','in_queued','repairing','last_check','cleaning','returning');
        foreach ($statusList as $value) {
          $data = $order[$value];
          if (isset($data)) {
            $orderStatus[$value] = Carbon::parse($data)->format("H:i");
            $orderStatus[$value . "_date"] = Carbon::parse($data)->format("d/m/Y");
          } else {
            $orderStatus[$value] = " ";
            $orderStatus[$value . "_date"] = " ";
          }
        }
        $orderStatus['cost'] = number_format($order['cost']);

        for ($i=0;$i<5;$i++) {
          if (!strcmp($orderStatus[$statusList[$i]]," ") == 0) {
            if (!strcmp($orderStatus[$statusList[$i+1]]," ") == 0) {
              $borderStyle[$i] = "#6486E3";
              $lineStyle[$i] = "#6486E3";
            } else {
              $borderStyle[$i] = "#EF454D";
            }
          } else {
            $borderStyle[$i] = "#B7B7B7";
          }
        }

        if (!strcmp($orderStatus['returning']," ") == 0) {
          $borderStyle[5] = "#EF454D";
          $costStyle = "#03C04A";
        } else {
          $borderStyle[5] = "#B7B7B7";
          $costStyle = "#FFFFFF";
        }

        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(config('line.channel_access_token'));
        $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => config('line.channel_secret')]);

        $flexDataJson = (new LineFlexMessage)->repairStatusMessage($orderStatus, $borderStyle, $lineStyle, $costStyle);
        $multiMessageBuilder = new MultiMessageBuilder();
        $multiMessageBuilder->add(new RawMessageBuilder(json_decode($flexDataJson, true)));
        $response = $bot->pushMessage($lui,  $multiMessageBuilder);
    }

    function sendRepairStatus($event, $bot) {
        $userId = $event->getUserId();
        $customerId = Customer::where('line_id', '=', $userId)->value('id');
        $lastestCar = RepairOrder::where('customer_id', '=', $customerId)->orderBy('created_at', 'desc')->select('car_registration','vin')->first();
        $carRegis = $lastestCar['car_registration'];
        $vin = $lastestCar['vin'];

        $flexDataJson = (new LineFlexMessage)->repairListMessage($carRegis, $vin);
        $replyText = new RawMessageBuilder(json_decode($flexDataJson, true));
        $response = $bot->pushMessage($userId, $replyText);
    }

    function sendProfileMessage($event, $bot) {
        $userId = $event->getUserId();
        $customerId = Customer::where('line_id', '=', $userId)->value('id');

        if (is_null($customerId)) {
            $flexDataJson = (new LineFlexMessage)->unRegisteredProfileMessage();
        } else {
            $name = Customer::findorfail($customerId)['name'];
            $created_at = Customer::findorfail($customerId)['created_at'];
            $date = Carbon::parse($created_at)->format("d/m/Y");

            $flexDataJson = (new LineFlexMessage)->registeredProfileMessage($name, $date);
        }
        $replyText = new RawMessageBuilder(json_decode($flexDataJson, true));
        $response = $bot->pushMessage($userId, $replyText);
    }

    public static function sendConnectStatus($lui, $carRegis) {
        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(config('line.channel_access_token'));
        $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => config('line.channel_secret')]);

        $replyText = new TextMessageBuilder("Successfully connected with {$carRegis}");
        $response = $bot->pushMessage($lui, $replyText);
    }
}
