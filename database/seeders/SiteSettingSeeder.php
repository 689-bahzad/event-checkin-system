<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $site_setting = SiteSetting::create([
            'page_title' => 'home',
           'site_css' => '
            @import url(\'https://fonts.googleapis.com/css2?family=Open+Sans:wght@500&display=swap\');

            body {
                font-family: \'Open Sans\', sans-serif !important;
            }

            * {
                margin: 0px;
                padding: 0px;
                box-sizing: border-box;
            }

            .section_draw {
                background-color: #000;
            }

            .section_draw .container {
                max-width: 600px;
                margin: auto;
                background-repeat: no-repeat;
                background-size: contain;
                padding-top: 50px;
                padding-bottom: 250px;
                height: 100vh;
            }

            .section_draw .img_wrapper {
                width: 100%;
                height: auto;
            }

            .wrapper_box {
                position: relative;
                margin-top: 150px;
            }

            .main_box {
                margin: auto;
                max-width: 440px;
            }

            .heading_seconday {
                margin-bottom: 20px;
                color: white;
                font-size: 25px;
                text-align: center;
                font-weight: 700;
                font-family: "Niramit", sans-serif;
                line-height: 35px;
            }

            .heading_primery {
                background: #FCD77E;
                background: linear-gradient(to left, #FCD77E 0%, #C2832D 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                font-size: 26px;
                font-weight: 800;
                text-align: center;
                padding: 16px 0px 40px 0px;
                -webkit-text-stroke-width: 1.3px;
                -webkit-text-stroke-color: #914f2c;
                background-clip: text;
            }

            .box_num {
                margin-bottom: 35px !important;
            }

            .box_border {
                border-width: 7px;
                position: relative;
                right: 52px;
                border-style: solid;
                background-color: aliceblue;
                border-image-slice: 1;
                border-radius: 12px;
                padding: 30px 45px 24px 45px;
                width: 100%;
                margin: auto;
                text-align: center;
                border-color: #C2832D;
            }

            .draw_heading {
                background: linear-gradient(to left, #41464b 0%, #131312 100%);
                font-size: 27px;
                font-weight: 800;
                text-align: center;
                padding-bottom: 20px;
                -webkit-text-stroke-width: 0.1px;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                font-family: sans-serif;
            }

            .box_num input {
                padding: 16px 10px;
                border-radius: 40px;
                width: 100%;
            }

            .box_ticket a {
                font-size: 14px;
                font-weight: 500;
                border-radius: 30px;
                color: white;
                padding: 13px;
                border: none;
                width: 100%;
                text-decoration: none;
            }

            .box_ticket p {
                margin-top: 50px;
                font-size: 13px;
                font-weight: 800;
            }

            @media only screen and (max-width: 520px) {
                .main_box {
                    max-width: 290px;
                }

                .heading_primery {
                    font-size: 20px;
                }

                .heading_seconday {
                    font-size: 17px;
                }

                .box_border {
                    padding: 29px 10px 35px 10px;
                }

                .draw_heading {
                    font-size: 18px;
                }

                .box_ticket p {
                    margin-top: 27px;
                }

                .box_num input {
                    padding: 11px 10px;
                }

                .box_ticket a {
                    padding: 11px 18px !important;
                }
            }
        ',

        ]);
        $site_setting->copyMedia(public_path('assets/frontend/images/registration.jpg'))->toMediaCollection('images');
  
  

        $site_setting = SiteSetting::create([
            'page_title' => 'qrCode',
        ]);
        $site_setting->copyMedia(public_path('assets/frontend/images/registration.jpg'))->toMediaCollection('images');


        $site_setting = SiteSetting::create([
            'page_title' => 'luckyDraw',
        ]);
        $site_setting->copyMedia(public_path('assets/frontend/images/check-in.jpg'))->toMediaCollection('images');

        $site_setting = SiteSetting::create([
            'page_title' => 'luckyNumber',
        ]);
        $site_setting->copyMedia(public_path('assets/frontend/images/check-in.jpg'))->toMediaCollection('images');


        $site_setting = SiteSetting::create([
            'page_title' => 'checkIn',
        ]);
        $site_setting->copyMedia(public_path('assets/frontend/images/check-in.jpg'))->toMediaCollection('images');
    
        $site_setting = SiteSetting::create([
            'page_title' => 'feedback',
        ]);
        $site_setting->copyMedia(public_path('assets/frontend/images/registration.jpg'))->toMediaCollection('images');
    
        $site_setting = SiteSetting::create([
            'page_title' => 'emailTemplate',
        ]);
        $site_setting->copyMedia(public_path('assets/frontend/images/registration.jpg'))->toMediaCollection('images');
    
        $site_setting = SiteSetting::create([
            'page_title' => 'directCheckIn',
        ]);
        $site_setting->copyMedia(public_path('assets/frontend/images/check-in.jpg'))->toMediaCollection('images');
    }
}
