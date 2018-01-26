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
            'border_width' => '',
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
            'twitter' => 'http://twitter.com/',
            'facebook' => 'http://facebook.com/',
            'pinterest' => 'http://pinterest.com/',
            'linkedin' => 'http://linkedin.com/',
            'youtube' => 'http://youtube.com/',
            'rss' => 'http://',
        ];
    }
}
