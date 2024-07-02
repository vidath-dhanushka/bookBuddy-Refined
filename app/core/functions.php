<?php

function show($stuff)
{
    echo "<pre>";
    print_r($stuff);
    echo "</pre>";
}

function set_value($key, $default = '')
{
    if (!empty($_POST[$key])) {
        return $_POST[$key];
    } else
    if (!empty($default)) {
        return $default;
    }
    return "";
}

function redirect($link)
{
    header("Location:" . ROOT . "/" . $link);
    die;
}

function message($msg = '', $erase = false)
{

    if (!empty($msg)) {
        $_SESSION['message'] = $msg;
    } else {
        if (!empty($_SESSION['message'])) {

            $msg = $_SESSION['message'];
            if ($erase) {
                unset($_SESSION['message']);
            }
            return $msg;
        }
    }

    return false;
}

function esc($str)
{
    return nl2br(htmlspecialchars($str));
}

function resize_image($filename, $max_size = 700)
{
    $ext = explode(".", $filename);
    $ext = strtolower(end($ext));

    if (file_exists($filename)) {
        switch ($ext) {
            case 'png':
                $image = imagecreatefrompng($filename);
                break;
            case 'gif':
                $image = imagecreatefromgif($filename);
            case 'jpg':
            case 'jpeg':
                $image = imagecreatefromjpeg($filename);
                break;
            default:
                $image = imagecreatefromjpeg($filename);
                break;
        }

        $src_w = imagesx($image);
        $src_h = imagesy($image);

        if ($src_w > $src_h) {
            $dst_w = $max_size;
            $dst_h = ($src_h / $src_w) * $max_size;
        } else {
            $dst_w = ($src_w / $src_h) * $max_size;
            $dst_h = $max_size;
        }

        $dst_image = imagecreatetruecolor($dst_w, $dst_h);

        imagecopyresampled($dst_image, $image, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);

        imagedestroy($image);

        imagejpeg($dst_image, $filename, 90);
        switch ($ext) {
            case 'png':
                imagepng($dst_image, $filename);
                break;
            case 'gif':
                imagegif($dst_image, $filename);
            case 'jpg':
            case 'jpeg':
                imagejpeg($dst_image, $filename, 90);
                break;
            default:
                imagejpeg($dst_image, $filename, 90);
                break;
        }

        imagedestroy($dst_image);
    }

    return $filename;
}

function toCamelCase($inputString)
{
    // Remove any leading or trailing whitespaces
    $inputString = trim($inputString);

    // Replace spaces, underscores, or other separators with a single space
    $inputString = preg_replace('/[\s_]+/', ' ', $inputString);

    // Capitalize the first letter of each word
    $camelCaseString = lcfirst(ucwords($inputString));

    return str_replace(' ', '', $camelCaseString);
}

function camelCaseToWords($input)
{
    // Add a space before each capital letter (except the first one)
    $result = preg_replace('/([a-z])([A-Z])/', "$1 $2", $input);

    // Capitalize the first letter
    $result = ucfirst($result);

    return $result;
}
