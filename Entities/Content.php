<?php namespace VaahCms\Themes\BtFourPointFour\Entities;

use Illuminate\Database\Eloquent\Model;

class Content extends \VaahCms\Modules\Cms\Entities\Content {

	//--------------------------------------------------------------
    public static function blogs()
    {

        $select_fields = [
            'title',
        ];

        $list = static::whereHas('contentType', function ($q){
            $q->where('slug', 'blogs');
        })
            ->whereHas('fields', function($f) use ($select_fields){
                $f->whereHas('field', function ($field) use ($select_fields){
                    $field->whereIn('slug', $select_fields);
                });
            })
            ->with(['fields'])
            ->paginate(10);

        return $list;

    }
	//--------------------------------------------------------------
	//--------------------------------------------------------------
	//--------------------------------------------------------------

}
