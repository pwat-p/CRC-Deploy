<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LineFlexMessage extends Model
{
    public function repairStatusMessage($orderStatus, $borderStyle, $lineStyle, $costStyle) {
        return <<<JSON
{
"type": "flex",
    "altText": "Repair Status",
    "contents": {
      "type": "bubble",
      "size": "giga",
      "header": {
        "type": "box",
        "layout": "vertical",
        "contents": [
          {
            "type": "box",
            "layout": "vertical",
            "contents": [
              {
                "type": "text",
                "text": "สถานะงานซ่อมรถยนต์",
                "color": "#ffffff",
                "size": "xl",
                "weight": "bold"
              },
              {
                "type": "box",
                "layout": "horizontal",
                "contents": [
                  {
                    "type": "text",
                    "text": "เจ้าของรถ",
                    "color": "#ffffff66",
                    "size": "md",
                    "flex": 0
                  },
                  {
                    "type": "text",
                    "text": "$orderStatus[name]",
                    "color": "#ffffff",
                    "size": "md"
                  }
                ],
                "justifyContent": "center",
                "spacing": "xl"
              },
              {
                "type": "box",
                "layout": "horizontal",
                "contents": [
                  {
                    "type": "text",
                    "text": "เลขทะเบียน",
                    "color": "#ffffff66",
                    "size": "md",
                    "flex": 0
                  },
                  {
                    "type": "text",
                    "text": "$orderStatus[car_registration]",
                    "color": "#ffffff",
                    "size": "md"
                  }
                ],
                "spacing": "xl"
              },
              {
                "type": "box",
                "layout": "horizontal",
                "contents": [
                  {
                    "type": "text",
                    "text": "หมายเลขตัวถัง",
                    "color": "#ffffff66",
                    "size": "md",
                    "flex": 0
                  },
                  {
                    "type": "text",
                    "text": "$orderStatus[vin]",
                    "color": "#ffffff",
                    "size": "md"
                  }
                ],
                "spacing": "xl"
              }
            ]
          }
        ],
        "paddingAll": "20px",
        "backgroundColor": "#0367D3",
        "spacing": "md",
        "height": "154px",
        "paddingTop": "22px"
      },
      "body": {
        "type": "box",
        "layout": "vertical",
        "contents": [
          {
            "type": "box",
            "layout": "horizontal",
            "contents": [
              {
                "type": "text",
                "text": "$orderStatus[car_received]",
                "size": "sm",
                "gravity": "center"
              },
              {
                "type": "box",
                "layout": "vertical",
                "contents": [
                  {
                    "type": "filler"
                  },
                  {
                    "type": "box",
                    "layout": "vertical",
                    "contents": [],
                    "cornerRadius": "30px",
                    "height": "12px",
                    "width": "12px",
                    "borderColor": "$borderStyle[0]",
                    "borderWidth": "2px"
                  },
                  {
                    "type": "filler"
                  }
                ],
                "flex": 0
              },
              {
                "type": "text",
                "text": "รับรถเข้าบริการ",
                "gravity": "center",
                "flex": 4,
                "size": "sm"
              }
            ],
            "spacing": "lg",
            "cornerRadius": "30px",
            "margin": "xl"
          },
          {
            "type": "box",
            "layout": "horizontal",
            "contents": [
              {
                "type": "box",
                "layout": "baseline",
                "contents": [
                  {
                    "type": "filler"
                  }
                ],
                "flex": 1
              },
              {
                "type": "box",
                "layout": "vertical",
                "contents": [
                  {
                    "type": "box",
                    "layout": "horizontal",
                    "contents": [
                      {
                        "type": "filler"
                      },
                      {
                        "type": "box",
                        "layout": "vertical",
                        "contents": [],
                        "width": "2px",
                        "backgroundColor": "$lineStyle[0]"
                      },
                      {
                        "type": "filler"
                      }
                    ],
                    "flex": 1
                  }
                ],
                "width": "12px"
              },
              {
                "type": "box",
                "layout": "vertical",
                "contents": [],
                "flex": 4
              }
            ],
            "spacing": "lg",
            "height": "32px"
          },
          {
            "type": "box",
            "layout": "horizontal",
            "contents": [
              {
                "type": "box",
                "layout": "horizontal",
                "contents": [
                  {
                    "type": "text",
                    "text": "$orderStatus[in_queued]",
                    "gravity": "center",
                    "size": "sm"
                  }
                ],
                "flex": 1
              },
              {
                "type": "box",
                "layout": "vertical",
                "contents": [
                  {
                    "type": "filler"
                  },
                  {
                    "type": "box",
                    "layout": "vertical",
                    "contents": [],
                    "cornerRadius": "30px",
                    "width": "12px",
                    "height": "12px",
                    "borderWidth": "2px",
                    "borderColor": "$borderStyle[1]"
                  },
                  {
                    "type": "filler"
                  }
                ],
                "flex": 0
              },
              {
                "type": "text",
                "text": "รอคิวซ่อม",
                "gravity": "center",
                "flex": 4,
                "size": "sm"
              }
            ],
            "spacing": "lg",
            "cornerRadius": "30px"
          },
          {
            "type": "box",
            "layout": "horizontal",
            "contents": [
              {
                "type": "box",
                "layout": "baseline",
                "contents": [
                  {
                    "type": "filler"
                  }
                ],
                "flex": 1
              },
              {
                "type": "box",
                "layout": "vertical",
                "contents": [
                  {
                    "type": "box",
                    "layout": "horizontal",
                    "contents": [
                      {
                        "type": "filler"
                      },
                      {
                        "type": "box",
                        "layout": "vertical",
                        "contents": [],
                        "width": "2px",
                        "backgroundColor": "$lineStyle[1]"
                      },
                      {
                        "type": "filler"
                      }
                    ],
                    "flex": 1
                  }
                ],
                "width": "12px"
              },
              {
                "type": "box",
                "layout": "vertical",
                "contents": [],
                "flex": 4
              }
            ],
            "spacing": "lg",
            "height": "32px"
          },
          {
            "type": "box",
            "layout": "horizontal",
            "contents": [
              {
                "type": "text",
                "text": "$orderStatus[repairing]",
                "gravity": "center",
                "size": "sm"
              },
              {
                "type": "box",
                "layout": "vertical",
                "contents": [
                  {
                    "type": "filler"
                  },
                  {
                    "type": "box",
                    "layout": "vertical",
                    "contents": [],
                    "cornerRadius": "30px",
                    "width": "12px",
                    "height": "12px",
                    "borderColor": "$borderStyle[2]",
                    "borderWidth": "2px"
                  },
                  {
                    "type": "filler"
                  }
                ],
                "flex": 0
              },
              {
                "type": "text",
                "text": "กำลังซ่อม",
                "gravity": "center",
                "flex": 4,
                "size": "sm"
              }
            ],
            "spacing": "lg",
            "cornerRadius": "30px"
          },
          {
            "type": "box",
            "layout": "horizontal",
            "contents": [
              {
                "type": "box",
                "layout": "baseline",
                "contents": [
                  {
                    "type": "filler"
                  }
                ],
                "flex": 1
              },
              {
                "type": "box",
                "layout": "vertical",
                "contents": [
                  {
                    "type": "box",
                    "layout": "horizontal",
                    "contents": [
                      {
                        "type": "filler"
                      },
                      {
                        "type": "box",
                        "layout": "vertical",
                        "contents": [],
                        "width": "2px",
                        "backgroundColor": "$lineStyle[2]"
                      },
                      {
                        "type": "filler"
                      }
                    ],
                    "flex": 1
                  }
                ],
                "width": "12px"
              },
              {
                "type": "box",
                "layout": "vertical",
                "contents": [],
                "flex": 4
              }
            ],
            "spacing": "lg",
            "height": "32px"
          },
          {
            "type": "box",
            "layout": "horizontal",
            "contents": [
              {
                "type": "text",
                "text": "$orderStatus[last_check]",
                "gravity": "center",
                "size": "sm"
              },
              {
                "type": "box",
                "layout": "vertical",
                "contents": [
                  {
                    "type": "filler"
                  },
                  {
                    "type": "box",
                    "layout": "vertical",
                    "contents": [],
                    "cornerRadius": "30px",
                    "width": "12px",
                    "height": "12px",
                    "borderColor": "$borderStyle[3]",
                    "borderWidth": "2px"
                  },
                  {
                    "type": "filler"
                  }
                ],
                "flex": 0
              },
              {
                "type": "text",
                "text": "ตรวจสอบครั้งสุดท้าย",
                "gravity": "center",
                "flex": 4,
                "size": "sm"
              }
            ],
            "spacing": "lg",
            "cornerRadius": "30px"
          },
          {
            "type": "box",
            "layout": "horizontal",
            "contents": [
              {
                "type": "box",
                "layout": "baseline",
                "contents": [
                  {
                    "type": "filler"
                  }
                ],
                "flex": 1
              },
              {
                "type": "box",
                "layout": "vertical",
                "contents": [
                  {
                    "type": "box",
                    "layout": "horizontal",
                    "contents": [
                      {
                        "type": "filler"
                      },
                      {
                        "type": "box",
                        "layout": "vertical",
                        "contents": [],
                        "width": "2px",
                        "backgroundColor": "$lineStyle[3]"
                      },
                      {
                        "type": "filler"
                      }
                    ],
                    "flex": 1
                  }
                ],
                "width": "12px"
              },
              {
                "type": "box",
                "layout": "vertical",
                "contents": [],
                "flex": 4
              }
            ],
            "spacing": "lg",
            "height": "32px"
          },
          {
            "type": "box",
            "layout": "horizontal",
            "contents": [
              {
                "type": "text",
                "text": "$orderStatus[cleaning]",
                "gravity": "center",
                "size": "sm"
              },
              {
                "type": "box",
                "layout": "vertical",
                "contents": [
                  {
                    "type": "filler"
                  },
                  {
                    "type": "box",
                    "layout": "vertical",
                    "contents": [],
                    "cornerRadius": "30px",
                    "width": "12px",
                    "height": "12px",
                    "borderColor": "$borderStyle[4]",
                    "borderWidth": "2px"
                  },
                  {
                    "type": "filler"
                  }
                ],
                "flex": 0
              },
              {
                "type": "text",
                "text": "ล้างทำความสะอาด",
                "gravity": "center",
                "flex": 4,
                "size": "sm"
              }
            ],
            "spacing": "lg",
            "cornerRadius": "30px"
          },
          {
            "type": "box",
            "layout": "horizontal",
            "contents": [
              {
                "type": "box",
                "layout": "baseline",
                "contents": [
                  {
                    "type": "filler"
                  }
                ],
                "flex": 1
              },
              {
                "type": "box",
                "layout": "vertical",
                "contents": [
                  {
                    "type": "box",
                    "layout": "horizontal",
                    "contents": [
                      {
                        "type": "filler"
                      },
                      {
                        "type": "box",
                        "layout": "vertical",
                        "contents": [],
                        "width": "2px",
                        "backgroundColor": "$lineStyle[4]"
                      },
                      {
                        "type": "filler"
                      }
                    ],
                    "flex": 1
                  }
                ],
                "width": "12px"
              },
              {
                "type": "box",
                "layout": "vertical",
                "contents": [],
                "flex": 4
              }
            ],
            "spacing": "lg",
            "height": "32px"
          },
          {
            "type": "box",
            "layout": "horizontal",
            "contents": [
              {
                "type": "text",
                "text": "$orderStatus[returning]",
                "gravity": "center",
                "size": "sm"
              },
              {
                "type": "box",
                "layout": "vertical",
                "contents": [
                  {
                    "type": "filler"
                  },
                  {
                    "type": "box",
                    "layout": "vertical",
                    "contents": [],
                    "cornerRadius": "30px",
                    "width": "12px",
                    "height": "12px",
                    "borderColor": "$borderStyle[5]",
                    "borderWidth": "2px"
                  },
                  {
                    "type": "filler"
                  }
                ],
                "flex": 0
              },
              {
                "type": "box",
                "layout": "horizontal",
                "contents": [
                  {
                    "type": "text",
                    "text": "พร้อมรับรถ",
                    "gravity": "center",
                    "flex": 0,
                    "size": "sm"
                  },
                  {
                    "type": "text",
                    "text": "($orderStatus[cost] บาท)",
                    "size": "sm",
                    "color": "$costStyle",
                    "offsetStart": "10px"
                  }
                ],
                "flex": 4
              }
            ],
            "spacing": "lg",
            "cornerRadius": "10px",
            "paddingBottom": "xl"
          }
        ]
      }
  }
}
JSON;
    }

    public function repairListMessage($carRegis, $vin) {
      $repairInfoURL = "https://liff.line.me/" . config("liff.repair_info_id");
        return <<<JSON
{
"type": "flex",
    "altText": "Repair Status",
    "contents": {
      "type": "bubble",
      "body": {
      "type": "box",
      "layout": "vertical",
      "spacing": "md",
      "contents": [
          {
          "type": "text",
          "text": "$carRegis",
          "size": "xl",
          "weight": "bold"
          },
          {
          "type": "box",
          "layout": "horizontal",
          "contents": [
              {
              "type": "text",
              "text": "เลขตัวถัง",
              "color": "#aaaaaa",
              "size": "sm",
              "flex": 1,
              "gravity": "bottom"
              },
              {
              "type": "text",
              "text": "$vin",
              "size": "md",
              "flex": 3,
              "gravity": "bottom"
              }
          ]
          }
      ]
      },
      "footer": {
      "type": "box",
      "layout": "vertical",
      "contents": [
          {
          "type": "button",
          "style": "primary",
          "color": "#0000FF",
          "margin": "xs",
          "action": {
              "type": "uri",
              "label": "ประวัติงานซ่อม",
              "uri": "$repairInfoURL"
          }
          }
      ]
      }
  }
}
JSON; 
    }

    public function unRegisteredProfileMessage() {
        $registerURL = "https://liff.line.me/" . config("liff.register_id");
        return <<<JSON
{
"type": "flex",
    "altText": "Profile",
    "contents": {
      "type": "bubble",
      "body": {
        "type": "box",
        "layout": "vertical",
        "spacing": "md",
        "contents": [
          {
            "type": "text",
            "text": "คุณยังไม่ได้ทำการลงทะเบียน",
            "size": "sm",
            "color": "#999999"
          }
        ]
      },
      "footer": {
        "type": "box",
        "layout": "vertical",
        "contents": [
          {
            "type": "button",
            "style": "primary",
            "color": "#0000FF",
            "margin": "xs",
            "action": {
              "type": "uri",
              "label": "ลงทะเบียน",
              "uri": "$registerURL"
            },
            "height": "md"
          }
        ]
      }
  }
}
JSON;
    }

    public function registeredProfileMessage($name, $date) {
        $repairInfoURL = "https://liff.line.me/" . config("liff.repair_info_id");
        $profileEditURL = "https://liff.line.me/" . config("liff.profile_edit_id");
        return <<<JSON
{
"type": "flex",
    "altText": "Profile",
    "contents": {
      "type": "bubble",
      "body": {
        "type": "box",
        "layout": "vertical",
        "spacing": "md",
        "contents": [
          {
            "type": "text",
            "text": "$name",
            "size": "md"
          },
          {
            "type": "box",
            "layout": "horizontal",
            "contents": [
              {
                "type": "text",
                "text": "วันที่ลงทะเบียน: ",
                "size": "xs",
                "color": "#AAAAAA",
                "flex": 1,
                "gravity": "bottom"
              },
              {
                "type": "text",
                "text": "$date",
                "flex": 2,
                "size": "sm"
              }
            ],
            "offsetStart": "sm"
          }
        ]
      },
      "footer": {
        "type": "box",
        "layout": "vertical",
        "contents": [
          {
            "type": "button",
            "style": "primary",
            "color": "#0000FF",
            "margin": "xs",
            "action": {
              "type": "uri",
              "label": "ประวัติงานซ่อม",
              "uri": "$repairInfoURL"
            },
            "height": "sm"
          },
          {
            "type": "button",
            "style": "secondary",
            "color": "#D3D3D3",
            "margin": "sm",
            "action": {
              "type": "uri",
              "label": "แก้ไขข้อมูลสมาชิก",
              "uri": "$profileEditURL"
            },
            "height": "sm"
          }
        ]
      }
  }
}
JSON;
    }

}
    
