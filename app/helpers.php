<?php
class Role
{
    const Admin = 'Admin';
    const User = 'User';

}

if (!function_exists('responseWithSuccess')) {
    function responseWithSuccess($message, $data = '')
    {
        return response()->json(['message' => $message, 'data' => $data], 200);
    }
}

if (!function_exists('responseWithError')) {

    function responseWithError($error_message, $code = 400, $data = null)
    {
        return response()->json(['message' => $error_message, 'data' => $data], $code);
    }
}
