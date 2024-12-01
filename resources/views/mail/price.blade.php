<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
</head>
<body style="margin: 0;padding: 0;width: 100% !important;height: 100%;font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';background-color: #ffffff;color: #718096;line-height: 1.4;">

<div style="background-color: #edf2f7;">
    <div style="padding: 25px 0;text-align: center;">
        <a href="{{ config('app.url') }}" style="color: #3d4852;font-size: 19px;font-weight: bold;text-decoration: none;display: inline-block;">{{ config('app.name') }}</a>
    </div>
    <div style="background-color: #ffffff;border-color: #e8e5ef;border-radius: 2px;border-width: 1px;box-shadow: 0 2px 0 rgba(0, 0, 150, 0.025), 2px 4px 0 rgba(0, 0, 150, 0.015);margin: 0 auto;padding: 0;width: 570px;">
        <div style="max-width: 100vw;padding: 32px;">
            <h1 style="margin-top: 0;text-align: left;font-size: 18px;font-weight: bold;color: #3d4852;">Hello!</h1>
            <p style="margin-top: 0;text-align: left;font-size: 16px;line-height: 1.5em;">The <a href="{{ $link }}">announcement</a>, you are following, price has been changed. Current price is: <strong>{{ $amount }} {{ $currency }}</strong>.</p>
            <hr style="margin-top: 25px;margin-bottom: 25px;height: 1px;background-color: #e8e5ef;border: transparent;" />
            <p style="margin-top: 0;text-align: left;font-size: 16px;line-height: 1.5em;">Regards,<br />{{ config('app.name') }}</p>
        </div>
    </div>
    <div style="max-width: 100vw;padding: 32px;">
        <p style="line-height: 1.5em;margin-top: 0;color: #b0adc5;font-size: 12px;text-align: center;">{{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</div>

</body>
</html>