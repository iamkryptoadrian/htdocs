<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" bgcolor="#F7F7F7" style="margin: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; padding: 0;">
  <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" bgcolor="#F7F7F7" style="width: 100% !important; margin: 0; padding: 0;">
    <tr>
      <td style="padding-right: 10px; padding-left: 10px;">
        <table class="content" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#F7F7F7" style="width: 480px; max-width: 100%; margin: 0 auto;">
          <tr>
            <td width="100%" valign="middle" style="text-align: center; padding: 20px 0 10px 0;">
              <a href="#"><img src="{{ asset('img/general/logo_dark.png') }}" width="130" height="76" border="0" alt="Rock Resorts Logo" style="display: block; margin: 0 auto;"></a>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td>
        <table class="content" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#F7F7F7" style="width: 480px; max-width: 100%; margin: 0 auto;">
          <tr>
            <td colspan="2" style="background: #fff; border-radius: 8px;">
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; padding: 32px 40px;">
                    <h2 style="color: #404040; font-weight: 300; margin: 0 0 12px 0; font-size: 20px; line-height: 30px;">Hi {{ ucfirst($booking->main_guest_first_name) }},</h2>
                    <p style="color: #666666; font-weight: 400; font-size: 15px; line-height: 21px;">The property is looking forward to receiving your feedback soon</p>
                    <table width="100%" border="2" cellspacing="0" cellpadding="0" style="margin: 24px 0; color: #666666; font-weight: 400; font-size: 15px; line-height: 21px; border: 0;">
                      <tr>
                        <td style="padding: 20px 20px 0px; font-weight: 700; font-size: 25px;border:0;">
                            The Rock Resorts<br>
                          <p style="padding-top: 0px; font-weight: 700; font-size: 12px;">From {{ $booking->check_in_date->format('M d, Y') }} to {{ $booking->check_out_date->format('M d, Y') }}</p>
                          <p style="padding-top: 0px; font-weight: 700; font-size: 12px;">{{ ucfirst($booking->package_name) }}</p>
                          <p style="padding-top: 0px; font-weight: 700; font-size: 12px;">{{ count($roomsDetails) }} ({{ implode(', ', array_column($roomsDetails, 'room_name')) }}) - {{ $totalGuests }} Guests</p>
                        </td>
                      </tr>
                      <tr>
                        <td style="padding: 20px 20px 0px; font-weight: 700; font-size: 25px;border:0;">
                            How was your stay at The Rock Resorts?	<br>
                            <a href="https://tinyurl.com/therockresorts"><img src="{{ assets('/img/general/review.jpg')"></a>
                        </td>
                      </tr>
                    </table>
                    <p style="color: #666666; font-weight: 400; font-size: 15px; line-height: 21px;">Hope to see you again.</p>
                    <p style="color: #666666; font-weight: 400; font-size: 17px; line-height: 24px; margin-bottom: 6px; margin-top: 24px;">Cheers,</p>
                    <p style="color: #666666; font-weight: 400; font-size: 17px; margin-bottom: 6px; margin-top: 10px;">Managment,<br>
                    The Rock Resorts</p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <table class="content" align="center" cellpadding="0" cellspacing="0" border="0" style="width: 480px; max-width: 100%; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; margin: 0 auto;">
          <tr>
            <td style="padding-top: 24px;">
              <table cellspacing="0" cellpadding="0" width="100%">
                <tr>
                  <td style="background-color: #dedede; width: 100%; font-size: 1px; height: 1px; line-height: 1px;">&nbsp;</td>
                </tr>
              </table>
            </td>
          </tr>
          <tr class="footer-nav">
            <td class="grid__col" style="padding: 9px 0; text-align: center;">
              <table cellspacing="0" cellpadding="0" width="100%" style="margin: 0 auto;">
                <tr>
                  <td width="auto" style="display: inline-block; padding: 9px 15px 9px 10px; line-height: 11px;" align="center" valign="middle">
                    <a style="text-decoration: none; color: #0f90ba; font-size: 11px; color: #666666; text-transform: uppercase;" target="_blank" href="#">My Account</a>
                  </td>
                  <td width="auto" style="display: inline-block; padding: 9px 15px 9px 10px; line-height: 11px;" align="center" valign="middle">
                    <a style="text-decoration: none; color: #0f90ba; font-size: 11px; color: #666666; text-transform: uppercase;" target="_blank" href="#">Privacy</a>
                  </td>
                  <td width="auto" style="display: inline-block; padding: 9px 15px 9px 10px; line-height: 11px;" align="center" valign="middle">
                    <a style="text-decoration: none; color: #0f90ba; font-size: 11px; color: #666666; text-transform: uppercase;" target="_blank" href="#">Terms</a>
                  </td>
                  <td width="auto" style="display: inline-block; padding: 9px 15px 9px 10px; line-height: 11px;" align="center" valign="middle">
                    <a style="text-decoration: none; color: #0f90ba; font-size: 11px; color: #666666; text-transform: uppercase;" target="_blank" href="#">Blog</a>
                  </td>
                  <td width="auto" style="display: inline-block; line-height: 11px; padding-left: 10px;" align="center" valign="middle">
                    <a style="text-decoration: none; color: #0f90ba; display: inline-block; height: 22px; vertical-align: middle; margin-left: 5px;" href="">
                        <img src="https://cdn.evbstatic.com/s3-s3/marketing/emails/images/icons/facebook.png" title="Facebook" alt="Facebook" style="display: block;" border="0" width="22" height="22">
                    </a>
                    <a style="text-decoration: none; color: #0f90ba; display: inline-block; height: 22px; vertical-align: middle; margin-left: 5px;" href="https://twitter.com/roomstonite">
                        <img src="https://cdn.evbstatic.com/s3-s3/marketing/emails/images/icons/twitter.png" title="Twitter" alt="Twitter" style="display: block;" border="0" width="22" height="22">
                    </a>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>
              <table cellspacing="0" cellpadding="0" width="100%">
                <tr>
                  <td style="background-color: #dedede; width: 100%; font-size: 1px; height: 1px; line-height: 1px;">&nbsp;</td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td class="grid__col" style="padding: 24px 0; text-align: center;">
              <div style="color: #666666; font-weight: 400; font-size: 13px; line-height: 18px; font-weight: 300; padding-bottom: 6px;">
                <a style="text-decoration: none; color: #0f90ba;" href="https://vynzio.co" target="_blank">Made with ♡ By Vynzio.co</a>
              </div>
              <div style="color: #666666; font-weight: 400; font-size: 13px; line-height: 18px; font-weight: 300;">
                Copyright © 2024 The Rock Resorts. All rights reserved.
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
