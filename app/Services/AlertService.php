<?php
namespace App\Services;
class AlertService{

public static function updated($message = null)
{
    notyf()->success($message ? $message: 'Cập nhật thành công!');
}

public static function created($message = null)
{
    notyf()->success($message ? $message: 'Tạo thành công!');
}
}