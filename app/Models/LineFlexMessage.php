<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LineFlexMessage extends Model
{
    public function repairStatusMessage($orderStatus, $borderStyle, $lineStyle, $costStyle) {
      $image_url['model_image'] = config("line.endpoint_url") . $orderStatus['model_image'];
      $image_url['car_received'] = config("line.endpoint_url") . "/icon/car_received.png";
      $image_url['in_queued'] = config("line.endpoint_url") . "/icon/in_queued.png";
      $image_url['repairing'] = config("line.endpoint_url") . "/icon/repairing.png";
      $image_url['last_check'] = config("line.endpoint_url") . "/icon/last_check.png";
      $image_url['cleaning'] = config("line.endpoint_url") . "/icon/cleaning.png";
      $image_url['returning'] = config("line.endpoint_url") . "/icon/returning.png";
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
            "type": "text",
            "text": "สถานะงานซ่อมรถยนต์",
            "color": "#ffffff",
            "size": "xl",
            "weight": "bold",
            "align": "center"
          },
          {
            "type": "box",
            "layout": "vertical",
            "contents": [
              {
                "type": "text",
                "text": "$orderStatus[model]",
                "size": "md",
                "offsetStart": "xl",
                "weight": "bold"
              },
              {
                "type": "box",
                "layout": "horizontal",
                "contents": [
                  {
                    "type": "image",
                    "url": "$image_url[model_image]",
                    "size": "100px",
                    "flex": 1,
                    "gravity": "center",
                    "offsetStart": "md"
                  },
                  {
                    "type": "box",
                    "layout": "vertical",
                    "contents": [
                      {
                        "type": "box",
                        "layout": "vertical",
                        "contents": [
                          {
                            "type": "text",
                            "text": "เจ้าของรถ",
                            "size": "xxs"
                          },
                          {
                            "type": "text",
                            "text": "$orderStatus[name]",
                            "size": "sm",
                            "offsetStart": "xl"
                          }
                        ],
                        "justifyContent": "center"
                      },
                      {
                        "type": "box",
                        "layout": "vertical",
                        "contents": [
                          {
                            "type": "text",
                            "text": "เลขทะเบียน",
                            "size": "xxs",
                            "flex": 0
                          },
                          {
                            "type": "text",
                            "text": "$orderStatus[car_registration]",
                            "size": "sm",
                            "offsetStart": "xl"
                          }
                        ]
                      },
                      {
                        "type": "box",
                        "layout": "vertical",
                        "contents": [
                          {
                            "type": "text",
                            "text": "หมายเลขตัวถัง",
                            "size": "xxs",
                            "flex": 0
                          },
                          {
                            "type": "text",
                            "text": "$orderStatus[vin]",
                            "size": "sm",
                            "offsetStart": "xl"
                          }
                        ]
                      }
                    ],
                    "flex": 2
                  }
                ],
                "spacing": "lg"
              }
            ],
            "backgroundColor": "#ffffff",
            "cornerRadius": "xl",
            "paddingAll": "md"
          }
        ],
        "paddingAll": "10px",
        "backgroundColor": "#0367D3",
        "spacing": "md",
        "height": "210px",
        "paddingTop": "20px"
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
                "gravity": "center",
                "flex": 1,
                "align": "end"
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
                "type": "box",
                "layout": "horizontal",
                "contents": [
                  {
                    "type": "image",
                    "url": "$image_url[car_received]",
                    "gravity": "center",
                    "aspectMode": "fit",
                    "flex": 0,
                    "size": "32px"
                  },
                  {
                    "type": "text",
                    "text": "รับรถเข้าบริการ",
                    "gravity": "center",
                    "size": "sm",
                    "flex": 3
                  }
                ],
                "flex": 4,
                "paddingAll": "none",
                "spacing": "md"
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
                    "type": "text",
                    "text": "$orderStatus[car_received_date]",
                    "size": "10px",
                    "color": "#aaaaaa"
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
            "height": "24px"
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
                    "size": "sm",
                    "align": "end"
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
                "type": "box",
                "layout": "horizontal",
                "contents": [
                  {
                    "type": "image",
                    "url": "$image_url[in_queued]",
                    "gravity": "center",
                    "aspectMode": "cover",
                    "flex": 0,
                    "size": "32px"
                  },
                  {
                    "type": "text",
                    "text": "รอคิวซ่อม",
                    "gravity": "center",
                    "size": "sm",
                    "flex": 3
                  }
                ],
                "flex": 4,
                "paddingAll": "none",
                "spacing": "md"
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
                    "type": "text",
                    "text": "$orderStatus[in_queued_date]",
                    "size": "10px",
                    "color": "#aaaaaa"
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
            "height": "24px"
          },
          {
            "type": "box",
            "layout": "horizontal",
            "contents": [
              {
                "type": "text",
                "text": "$orderStatus[repairing]",
                "gravity": "center",
                "size": "sm",
                "align": "end"
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
                "type": "box",
                "layout": "horizontal",
                "contents": [
                  {
                    "type": "image",
                    "url": "$image_url[repairing]",
                    "gravity": "center",
                    "aspectMode": "fit",
                    "flex": 0,
                    "size": "32px"
                  },
                  {
                    "type": "text",
                    "text": "กำลังซ่อม",
                    "gravity": "center",
                    "size": "sm",
                    "flex": 3
                  }
                ],
                "flex": 4,
                "paddingAll": "none",
                "spacing": "md"
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
                    "type": "text",
                    "text": "$orderStatus[repairing_date]",
                    "size": "10px",
                    "color": "#aaaaaa"
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
            "height": "24px"
          },
          {
            "type": "box",
            "layout": "horizontal",
            "contents": [
              {
                "type": "text",
                "text": "$orderStatus[last_check]",
                "gravity": "center",
                "size": "sm",
                "align": "end"
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
                "type": "box",
                "layout": "horizontal",
                "contents": [
                  {
                    "type": "image",
                    "url": "$image_url[last_check]",
                    "gravity": "center",
                    "aspectMode": "fit",
                    "flex": 0,
                    "size": "32px"
                  },
                  {
                    "type": "text",
                    "text": "ตรวจสอบครั้งสุดท้าย",
                    "gravity": "center",
                    "size": "sm",
                    "flex": 3
                  }
                ],
                "flex": 4,
                "paddingAll": "none",
                "spacing": "md"
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
                    "type": "text",
                    "text": "$orderStatus[last_check_date]",
                    "size": "10px",
                    "color": "#aaaaaa"
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
            "height": "24px"
          },
          {
            "type": "box",
            "layout": "horizontal",
            "contents": [
              {
                "type": "text",
                "text": "$orderStatus[cleaning]",
                "gravity": "center",
                "size": "sm",
                "align": "end"
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
                "type": "box",
                "layout": "horizontal",
                "contents": [
                  {
                    "type": "image",
                    "url": "$image_url[cleaning]",
                    "gravity": "center",
                    "aspectMode": "fit",
                    "flex": 0,
                    "size": "32px"
                  },
                  {
                    "type": "text",
                    "text": "ล้างทำความสะอาด",
                    "gravity": "center",
                    "size": "sm",
                    "flex": 3
                  }
                ],
                "flex": 4,
                "paddingAll": "none",
                "spacing": "md"
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
                    "type": "text",
                    "text": "$orderStatus[cleaning_date]",
                    "size": "10px",
                    "color": "#aaaaaa"
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
            "height": "24px"
          },
          {
            "type": "box",
            "layout": "horizontal",
            "contents": [
              {
                "type": "text",
                "text": "$orderStatus[returning]",
                "gravity": "center",
                "size": "sm",
                "align": "end"
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
                    "type": "image",
                    "url": "$image_url[returning]",
                    "gravity": "center",
                    "aspectMode": "fit",
                    "flex": 0,
                    "size": "32px"
                  },
                  {
                    "type": "text",
                    "text": "พร้อมรับรถ",
                    "gravity": "center",
                    "size": "sm",
                    "flex": 3
                  }
                ],
                "flex": 4,
                "paddingAll": "none",
                "spacing": "md"
              }
            ],
            "spacing": "lg",
            "cornerRadius": "10px"
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
                    "type": "text",
                    "text": "$orderStatus[returning_date]",
                    "size": "10px",
                    "color": "#aaaaaa"
                  }
                ],
                "flex": 1
              },
              {
                "type": "box",
                "layout": "vertical",
                "contents": [],
                "width": "12px",
                "flex": 0
              },
              {
                "type": "box",
                "layout": "horizontal",
                "contents": [
                  {
                    "type": "box",
                    "layout": "horizontal",
                    "contents": [],
                    "flex": 1
                  },
                  {
                    "type": "text",
                    "text": "($orderStatus[cost] บาท)",
                    "flex": 6,
                    "size": "xs",
                    "color": "$costStyle",
                    "offsetStart": "sm"
                  }
                ],
                "flex": 4
              }
            ],
            "spacing": "lg",
            "height": "24px"
          },
          {
            "type": "box",
            "layout": "horizontal",
            "contents": [],
            "height": "10px"
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
    
