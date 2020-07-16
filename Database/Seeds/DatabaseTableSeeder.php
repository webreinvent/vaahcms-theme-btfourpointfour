<?php
namespace VaahCms\Themes\BtFourPointFour\Database\Seeds;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use VaahCms\Modules\Cms\Entities\ContentType;
use WebReinvent\VaahCms\Entities\ThemeTemplate;

class DatabaseTableSeeder extends Seeder
{

    public $theme;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->theme = DB::table('vh_themes')
            ->where('slug', 'btfourpointfour')
            ->first();

        $this->seedThemeLocations();
        $this->seedTemplates();
        $this->seedContentTypes();
    }

    //---------------------------------------------------------------

    public function getListFromJson($json_file_name)
    {
        $json_file = __DIR__."/json/".$json_file_name;
        $jsonString = file_get_contents($json_file);
        $list = json_decode($jsonString, true);
        return $list;
    }
    //---------------------------------------------------------------
    public function storeSeeds($table, $list, $primary_key='slug', $create_slug=true, $create_slug_from='name')
    {
        foreach ($list as $item)
        {
            if($create_slug)
            {
                $item['slug'] = Str::slug($item[$create_slug_from]);
            }

            $item['vh_theme_id'] = $this->theme->id;

            $record = DB::table($table)
                ->where('vh_theme_id', $this->theme->id)
                ->where($primary_key, $item[$primary_key])
                ->first();

            if(!$record)
            {
                DB::table($table)->insert($item);
            } else{
                DB::table($table)->where($primary_key, $item[$primary_key])
                    ->update($item);
            }
        }
    }
    //---------------------------------------------------------------
    public function storeSeedsWithUuid($table, $list, $primary_key='slug', $create_slug=true, $create_slug_from='name')
    {
        foreach ($list as $item)
        {
            if($create_slug)
            {
                $item['slug'] = Str::slug($item[$create_slug_from]);
            }

            $item['uuid'] = Str::uuid();

            $record = DB::table($table)
                ->where('vh_theme_id', $this->theme->id)
                ->where($primary_key, $item[$primary_key])
                ->first();


            if(!$record)
            {
                DB::table($table)->insert($item);
            } else{
                DB::table($table)->where($primary_key, $item[$primary_key])
                    ->update($item);
            }
        }



    }
    //---------------------------------------------------------------
    public function seedThemeLocations()
    {
        $list = $this->getListFromJson("theme_locations.json");
        $this->storeSeeds('vh_theme_locations', $list);
    }
    //---------------------------------------------------------------
    public function seedTemplates()
    {
        $templates = $this->getListFromJson("templates.json");

        foreach ($templates as $template){


            $template['template']['slug'] = Str::slug($template['template']['name']);
            $template['template']['vh_theme_id'] = $this->theme->id;


            $template_exist = DB::table('vh_theme_templates')
                ->where('vh_theme_id', $this->theme->id)
                ->where('slug', $template['template']['slug'])
                ->first();

            if(!$template_exist)
            {
                $stored_template = DB::table('vh_theme_templates')->insert($template['template']);
            } else{
                $stored_template = DB::table('vh_theme_templates')
                    ->where('vh_theme_id', $this->theme->id)
                    ->where('slug', $template['template']['slug'])
                    ->update($template['template']);
            }

            $stored_template = DB::table('vh_theme_templates')
                ->where('vh_theme_id', $this->theme->id)
                ->where('slug', $template['template']['slug'])
                ->first();

            $stored_template = ThemeTemplate::find($stored_template->id);


            //template groups
            ThemeTemplate::syncWithFormGroups($stored_template, $template['groups']);


        }

    }
    //---------------------------------------------------------------
    public function seedContentTypes()
    {
        $content_types = $this->getListFromJson("content_types.json");

        foreach ($content_types as $content_type){

            $exist = DB::table('vh_cms_content_types')
                ->where('slug', $content_type['content']['slug'])
                ->first();

            $content_type['content']['uuid'] = Str::uuid();
            $content_type['content']['content_statuses'] = json_encode($content_type['content']['content_statuses']);

            if(!$exist)
            {
                $stored = DB::table('vh_cms_content_types')->insert($content_type['content']);
            } else{
                $stored = DB::table('vh_cms_content_types')
                    ->where('slug', $content_type['content']['slug'])
                    ->update($content_type['content']);
            }

            $stored = DB::table('vh_cms_content_types')
                ->where('slug', $content_type['content']['slug'])
                ->first();

            $stored = ContentType::find($stored->id);


            //template groups
            ContentType::syncWithFormGroups($stored, $content_type['groups']);


        }

    }
    //---------------------------------------------------------------
    //---------------------------------------------------------------
    //---------------------------------------------------------------


}
