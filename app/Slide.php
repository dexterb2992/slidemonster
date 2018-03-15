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
            'type' => 'adcontent',
            'types' => [],
            'border_width' => 0,
            'border_style' => 'solid',
            'border_color' => '',
            'background_color' => '',
            'background_image' => 'tweed',
            'autoresponder_code' => '',
            'name_field' => 'name',
            'email_field' => 'email',
            'post_url' => '',
            'hidden_fields' => '',
            'name_label' => 'Name',
            'email_label' => 'Email',
            'button_label' => 'Subscribe',
            'button_color' => 'btn-primary',
            'button_style' => 'btn-simple',
            'button_size' => 'btn-md',
            'twitter' => '',
            'facebook' => '',
            'pinterest' => '',
            'linkedin' => '',
            'youtube' => '',
            'rss' => '',
        ];
    }
}
