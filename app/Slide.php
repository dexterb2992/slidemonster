<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $guarded = ['id'];

    public function getLeftColAttribute($value)
    {
        return json_decode($value);
    }

    public function getCenterColAttribute($value)
    {
        return json_decode($value);
    }

    public function getRightColAttribute($value)
    {
        return json_decode($value);
    }

    public function getOneColAttribute($value)
    {
        return json_decode($value);
    }


    public function setLeftColAttribute($value)
    {
        $this->attributes['left_col'] = json_encode($value);
    }

    public function setCenterColAttribute($value)
    {
        $this->attributes['center_col'] = json_encode($value);
    }

    public function setRightColAttribute($value)
    {
        $this->attributes['right_col'] = json_encode($value);
    }

    public function setOneColAttribute($value)
    {
        $this->attributes['one_col'] = json_encode($value);
    }

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

            'timer_type' => 'evergreen',
            'timer_label_size' => '20',
            'timer_digit_size' => '60',
            'timer_digit_text_shadow_x' => '1',
            'timer_digit_text_shadow_y' => '1',
            'timer_digit_text_shadow_blur' => '1',
            'timer_label_text_shadow_x' => '1',
            'timer_label_text_shadow_y' => '1',
            'timer_label_text_shadow_blur' => '1',

            'layout' => 1,

            'left_col' => ['adcontent', 'cta_btn'],
            'center_col' => ['optin', 'social'],
            'right_col' => ['timer'],
            
            'one_col' => ['adcontent', 'cta_btn', 'optin', 'timer', 'social']
        ];
    }
}
