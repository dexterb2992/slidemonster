<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $guarded = ['id'];

    public static function form()
    {
        return [
            'title' => '',
            'content' => '',
            'type' => '',
            'border_width' => '',
            'border_style' => '',
            'border_color' => '',
            'background_color' => '',
            'background_image' => '',
            'autoresponder_code' => '',
            'name' => '',
            'email' => '',
            'post_url' => '',
            'hidden_fields' => '',
            'name_label' => '',
            'email_label' => '',
            'button_label' => '',
            'button_color' => '',
            'button_style' => '',
            'twitter' => '',
            'facebook' => '',
            'pinterest' => '',
            'linkedin' => '',
            'youtube' => '',
            'rss' => '',
        ];
    }
}
