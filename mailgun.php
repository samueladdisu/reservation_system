<?php 


require 'vendor/autoload.php';

use Mailgun\Mailgun;
// First, instantiate the SDK with your API credentials

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$mg = Mailgun::create($_ENV['MAILGUN_API_KEY']);

$Message2 = <<< EOD
<!DOCTYPE html>
<html
    style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">

<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
        }

        img {
            border: 0 !important;
            outline: none !important;
        }

        p {
            Margin: 0px !important;
            Padding: 0px !important;
        }

        table {
            border-collapse: collapse;
            mso-table-lspace: 0px;
            mso-table-rspace: 0px;
        }

        td,
        a,
        span {
            border-collapse: collapse;
            mso-line-height-rule: exactly;
        }
    </style>

</head>

<body itemscope itemtype="http://schema.org/EmailMessage"
    style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;"
    bgcolor="#f6f6f6">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="em_full_wrap" align="center"
        bgcolor="#efefef">
        <tr>
            <td align="center" valign="top">
                <table align="center" width="650" border="0" cellspacing="0" cellpadding="0" class="em_main_table"
                    style="width:650px; table-layout:fixed;">
                    <tr>
                        <td align="center" valign="top" style="padding:0 25px;" class="em_aside10">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                <tr>
                                    <td height="26" style="height:26px;" class="em_h20">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top"><a href="#" target="_blank"
                                            style="text-decoration:none;"><img
                                                src="https://reservations.kurifturesorts.com/img/black_logo.svg"
                                                width="208" height="41" alt="Kuriftu" border="0"
                                                style="display:block; font-family:Arial, sans-serif; font-size:18px; line-height:25px; text-align:center; color:#1d4685; font-weight:bold; max-width:208px;"
                                                class="em_w150" /></a></td>
                                </tr>
                                <tr>
                                    <td height="28" style="height:28px;" class="em_h20">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table style="" width="100%" border="0" cellspacing="0" cellpadding="0" class="em_full_wrap" align="center"
        bgcolor="#efefef">
        <tr>
            <td align="center" valign="top" class="em_aside5">
                <table align="center" width="650" border="0" cellspacing="0" cellpadding="0" class="em_main_table"
                    style="width:650px; table-layout:fixed;">
                    <tr>
                        <td align="center" valign="top" style="padding:0 25px; background-color:#ffffff;"
                            class="em_aside10">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                <tr>
                                    <td height="25" style="height:25px;" class="em_h10">&nbsp;</td>
                                </tr>

                                <tr>
                                    <td height="22" style="height:22px;" class="em_h20">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="em_blue em_font_22" align="center" valign="top"
                                        style="font-family: Arial, sans-serif; font-size: 26px; line-height: 29px; color:#264780; font-weight:bold;">
                                        Thank You For Choosing Us</td>
                                </tr>
                                <tr>
                                    <td height="15" style="height:15px; font-size:0px; line-height:0px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="em_blue em_font_22" align="center" valign="top"
                                        style="font-family: Arial, sans-serif; font-size: 20px;font-weight:light;">
                                        Your Stay At Kuriftu</td>
                                </tr>
                                
                                <tr>
                                    <td height="15" style="height:15px; font-size:0px; line-height:0px;">&nbsp;</td>
                                </tr>
                               
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                <tr>
                                    <td class="em_blue em_font_22" align="center" valign="top"
                                        style="font-family: Arial, sans-serif; font-size: 18px;font-weight:light;">
                                        Forest View King Size Bed - entoto</td>
                                </tr>
                                <tr>
                                    <td height="40" style="height:40px;" class="em_h20">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top">
                                        <table border="0" cellspacing="0" cellpadding="0" align="center">
                                            <tr>
                                                <td width="30" style="width:80px;" align="center" valign="middle">
                                                <p>Check In</p>
                                                </td>
                                                
                                                <td width="30" style="width:30px;" align="center" valign="middle">
                                                </td>
                                                <td width="30" style="width:80px;" align="center" valign="middle">
                                                <p>Check Out</p>
                                                </td>
                                                
                                            </tr>
                                            <tr>
                                                <td width="30" style="width:80px;" align="center" valign="middle">
                                                <p>2020-12-12</p>
                                                </td>
                                                
                                                <td width="30" style="width:30px;" align="center" valign="middle">
                                                </td>
                                                <td width="30" style="width:80px;" align="center" valign="middle">
                                                <p>2020-20-20</p>
                                                </td>
                                                
                                            </tr>
                                        </table>
                                <tr>
                                    <td class="em_grey" align="" valign="top"
                                        style="font-family: Arial, sans-serif; font-size: 16px; line-height: 22px; color:#434343;">
                                        
                                    </td>
                                    <tr>
                                    <td height="20" style="height:20px;" class="em_h20">&nbsp;</td>
                                </tr>
                                    <tr>
                                    <td class="em_blue em_font_22" align="center" valign="top"
                                        style="font-family: Arial, sans-serif; font-size: 15px;font-weight:light;">
                                        Guests</td>
                                </tr>

                                <tr>
                                    <td class="em_blue em_font_22" align="center" valign="top"
                                        style="font-family: Arial, sans-serif; font-size: 15px;font-weight:light;">
                                        0 Adults 0 Teens 0 Kids</td>
                                </tr>
                                <tr>
                                    <td class="em_blue em_font_22" align="center" valign="top"
                                        style="font-family: Arial, sans-serif; font-size: 15px;font-weight:light;">
                                        $100 Per Night</td>
                                </tr>


                                </tr>
                                <tr>
                                    <td height="15" style="height:15px; font-size:1px; line-height:1px;">&nbsp;</td>
                                </tr>

                                <tr>
                                    <td height="20" style="height:20px; font-size:1px; line-height:1px;">&nbsp;</td>
                                </tr>

                                <tr>
                                    <td height="40" style="height:40px;" class="em_h10">&nbsp;</td>
                                </tr>

                            </table>
                            
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                <tr>
                                    <td class="em_blue em_font_22" align="center" valign="top"
                                        style="font-family: Arial, sans-serif; font-size: 18px;font-weight:light;">
                                        Forest View King Size Bed - entoto</td>
                                </tr>
                                <tr>
                                    <td height="40" style="height:40px;" class="em_h20">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top">
                                        <table border="0" cellspacing="0" cellpadding="0" align="center">
                                            <tr>
                                                <td width="30" style="width:100px;" align="center" valign="middle">
                                                <p>Check In</p>
                                                </td>
                                                
                                                <td width="30" style="width:30px;" align="center" valign="middle">
                                                </td>
                                                <td width="30" style="width:100px;" align="center" valign="middle">
                                                <p>Check Out</p>
                                                </td>
                                                
                                            </tr>
                                            <tr>
                                                <td width="30" style="width:100px;" align="center" valign="middle">
                                                <p>2020-12-12</p>
                                                </td>
                                                
                                                <td width="30" style="width:30px;" align="center" valign="middle">
                                                </td>
                                                <td width="30" style="width:100px;" align="center" valign="middle">
                                                <p>2020-20-20</p>
                                                </td>
                                                
                                            </tr>
                                        </table>
                                <tr>
                                    <td class="em_grey" align="" valign="top"
                                        style="font-family: Arial, sans-serif; font-size: 16px; line-height: 22px; color:#434343;">
                                        
                                    </td>
                                    <tr>
                                    <td height="20" style="height:20px;" class="em_h20">&nbsp;</td>
                                </tr>
                                    <tr>
                                    <td class="em_blue em_font_22" align="center" valign="top"
                                        style="font-family: Arial, sans-serif; font-size: 15px;font-weight:light;">
                                        Guests</td>
                                </tr>

                                <tr>
                                    <td class="em_blue em_font_22" align="center" valign="top"
                                        style="font-family: Arial, sans-serif; font-size: 15px;font-weight:light;">
                                        0 Adults 0 Teens 0 Kids</td>
                                </tr>
                                <tr>
                                    <td class="em_blue em_font_22" align="center" valign="top"
                                        style="font-family: Arial, sans-serif; font-size: 15px;font-weight:light;">
                                        $100 Per Night</td>
                                </tr>


                                </tr>
                                <tr>
                                    <td height="15" style="height:15px; font-size:1px; line-height:1px;">&nbsp;</td>
                                </tr>

                                <tr>
                                    <td height="20" style="height:20px; font-size:1px; line-height:1px;">&nbsp;</td>
                                </tr>

                                <tr>
                                    <td height="40" style="height:40px;" class="em_h10">&nbsp;</td>
                                </tr>

                            </table>
                            
                        </td>
                    </tr>
                    <tr>
                        <td height="15" class="em_h10" style="height:15px; font-size:1px; line-height:1px;">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="em_full_wrap" align="center"
        bgcolor="#efefef">
        <tr>
            <td align="center" valign="top">
                <table align="center" width="650" border="0" cellspacing="0" cellpadding="0" class="em_main_table"
                    style="width:650px; table-layout:fixed;">
                    <tr>
                        <td align="center" valign="top" style="padding:0 25px;" class="em_aside10">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                <tr>
                                    <td height="40" style="height:40px;" class="em_h20">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top">
                                        <table border="0" cellspacing="0" cellpadding="0" align="center">
                                            <tr>
                                                <td width="30" style="width:30px;" align="center" valign="middle"><a
                                                        href="#" target="_blank" style="text-decoration:none;"><img
                                                            src="https://app.mailgun.com/assets/pilot/images/templates/fb.png"
                                                            width="30" height="30" alt="Fb" border="0"
                                                            style="display:block; font-family:Arial, sans-serif; font-size:18px; line-height:25px; text-align:center; color:#000000; font-weight:bold; max-width:30px;" /></a>
                                                </td>
                                                <td width="12" style="width:12px;">&nbsp;</td>
                                                <td width="30" style="width:30px;" align="center" valign="middle"><a
                                                        href="#" target="_blank" style="text-decoration:none;"><img
                                                            src="https://app.mailgun.com/assets/pilot/images/templates/tw.png"
                                                            width="30" height="30" alt="Tw" border="0"
                                                            style="display:block; font-family:Arial, sans-serif; font-size:14px; line-height:25px; text-align:center; color:#000000; font-weight:bold; max-width:30px;" /></a>
                                                </td>
                                                <td width="12" style="width:12px;">&nbsp;</td>
                                                <td width="30" style="width:30px;" align="center" valign="middle"><a
                                                        href="#" target="_blank" style="text-decoration:none;"><img
                                                            src="https://app.mailgun.com/assets/pilot/images/templates/insta.png"
                                                            width="30" height="30" alt="Insta" border="0"
                                                            style="display:block; font-family:Arial, sans-serif; font-size:14px; line-height:25px; text-align:center; color:#000000; font-weight:bold; max-width:30px;" /></a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="16" style="height:16px; font-size:1px; line-height:1px; height:16px;">
                                        &nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="em_grey" align="center" valign="top"
                                        style="font-family: Arial, sans-serif; font-size: 15px; line-height: 18px; color:#434343; font-weight:bold;">
                                        Problems or questions?</td>
                                </tr>
                                <tr>
                                    <td height="10" style="height:10px; font-size:1px; line-height:1px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top" style="font-size:0px; line-height:0px;">
                                        <table border="0" cellspacing="0" cellpadding="0" align="center">
                                            <tr>
                                                <td width="15" align="left" valign="middle"
                                                    style="font-size:0px; line-height:0px; width:15px;"><a
                                                        href="mailto:meow@meowgun.com"
                                                        style="text-decoration:none;"><img
                                                            src="/assets/pilot/images/templates/email_img.png"
                                                            width="15" height="12" alt="" border="0"
                                                            style="display:block; max-width:15px;" /></a></td>
                                                <td width="9" style="width:9px; font-size:0px; line-height:0px;"
                                                    class="em_w5"><img src="/assets/pilot/images/templates/spacer.gif"
                                                        width="1" height="1" alt="" border="0" style="display:block;" />
                                                </td>
                                                <td class="em_grey em_font_11" align="left" valign="middle"
                                                    style="font-family: Arial, sans-serif; font-size: 13px; line-height: 15px; color:#434343;">
                                                    <a href="mailto:meow@meowgun.com"
                                                        style="text-decoration:none; color:#434343;">meow@meowgun.com</a>
                                                    <a href="mailto:marketing@mailgun.com"
                                                        style="text-decoration:none; color:#434343;">[mailto:marketing@mailgun.com]</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="9" style="font-size:0px; line-height:0px; height:9px;" class="em_h10">
                                        <img src="/assets/pilot/images/templates/spacer.gif" width="1" height="1" alt=""
                                            border="0" style="display:block;" /></td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top">
                                        <table border="0" cellspacing="0" cellpadding="0" align="center">
                                            <tr>
                                                <td width="12" align="left" valign="middle"
                                                    style="font-size:0px; line-height:0px; width:12px;"><a href="#"
                                                        target="_blank" style="text-decoration:none;"><img
                                                            src="/assets/pilot/images/templates/img_1.png" width="12"
                                                            height="16" alt="" border="0"
                                                            style="display:block; max-width:12px;" /></a></td>
                                                <td width="7" style="width:7px; font-size:0px; line-height:0px;"
                                                    class="em_w5">&nbsp;</td>
                                                <td class="em_grey em_font_11" align="left" valign="middle"
                                                    style="font-family: Arial, sans-serif; font-size: 13px; line-height: 15px; color:#434343;">
                                                    <a href="#" target="_blank"
                                                        style="text-decoration:none; color:#434343;">Meowgun</a> &bull;
                                                    123 Meow Way &bull; Cattown, CA 95389</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="35" style="height:35px;" class="em_h20">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="1" bgcolor="#dadada" style="font-size:0px; line-height:0px; height:1px;"><img
                                src="/assets/pilot/images/templates/spacer.gif" width="1" height="1" alt="" border="0"
                                style="display:block;" /></td>
                    </tr>
                    <tr>
                        <td align="center" valign="top" style="padding:0 25px;" class="em_aside10">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                <tr>
                                    <td height="16" style="font-size:0px; line-height:0px; height:16px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top">
                                        <table border="0" cellspacing="0" cellpadding="0" align="left"
                                            class="em_wrapper">
                                            <tr>
                                                <td class="em_grey" align="center" valign="middle"
                                                    style="font-family: Arial, sans-serif; font-size: 11px; line-height: 16px; color:#434343;">
                                                    &copy; Meowgun 2022 &nbsp;|&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="16" style="font-size:0px; line-height:0px; height:16px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="em_hide" style="line-height:1px;min-width:650px;background-color:#efefef;"><img
                                alt="" src="/assets/pilot/images/templates/spacer.gif" height="1" width="650"
                                style="max-height:1px; min-height:1px; display:block; width:650px; min-width:650px;"
                                border="0" /></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
EOD;

$mg->messages()->send('reservations.kurifturesorts.com', [
    'from'    => 'Natty-Resort@kurifturesorts.com',
    'to'      => 'samueladdisu7@gmail.com',
    'subject' => 'Natty Man',
    'html'    =>  $Message2
  ]);

  if($mg){
    echo 'Message Sent';
  }
