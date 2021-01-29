<?php
namespace VaahCms\Themes\BtFourPointFour\Database\Seeds;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Request;
use VaahCms\Modules\Cms\Entities\Content;
use VaahCms\Modules\Cms\Entities\ContentFormField;
use VaahCms\Modules\Cms\Entities\ContentType;
use WebReinvent\VaahCms\Entities\Theme;
use WebReinvent\VaahCms\Entities\ThemeTemplate;

class SampleDataTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seeds();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    function seeds()
    {

        $this->insertBlogs();

    }

    //-----------------------------------------------------------------
    public function getListFromJson($json_file_name)
    {
        $json_file = __DIR__."/json/".$json_file_name;
        $jsonString = file_get_contents($json_file);
        $list = json_decode($jsonString, true);
        return $list;
    }
    //-----------------------------------------------------------------
    public function insertBlogs()
    {

        $item = $this->getListFromJson("sample_blog.json");
        $faker = \Faker\Factory::create();

        $content_type_id = 1;

        $form_groups = ContentType::getItemWithRelations($content_type_id);

        if($form_groups['status'] == 'success')
        {
            $content_groups = $form_groups['data']->groups->toArray();
        }


        $content = ContentType::where('slug', 'blogs')->first();
        $theme = Theme::where('slug', 'btfourpointfour')->first();
        $template = ThemeTemplate::where('vh_theme_id', $theme->id)
            ->where('slug', 'blog')
            ->with(['groups.fields.type'])
            ->first();

        $template_groups = $template->groups->toArray();


        $item = [
            'name' => null,
            'slug' => null,
            'vh_cms_content_type_id' => $content->id,
            'vh_theme_id' => $theme->id,
            'vh_theme_template_id' => $template->id,
            'is_published_at' => null,
            'status' => 'published',
            'content_groups' => $content_groups,
            'template_groups' => $template_groups,
        ];

        $list = [];

        for($i=0;$i<=500;$i++)
        {
            $insert = $item;

            $insert['name'] = $faker->sentence;
            $insert['slug'] = \Str::slug($insert['name']);
            $insert['permalink'] = $insert['slug'];
            $insert['is_published_at'] = \Carbon::now();


            foreach ($insert['content_groups'] as $content_key => $content_group)
            {
                foreach ($content_group['fields'] as $key => $field)
                {
                    $value = $this->getFieldValue($field['type']['slug']);
                    $insert['content_groups'][$content_key]['fields'][$key]['content'] = $value;
                }

            }

            if(is_array($insert['template_groups']))
            {
                foreach ($insert['template_groups'] as $temp_key => $template_group)
                {

                    foreach ($template_group['fields'] as $t_f_key => $field)
                    {
                        $value = $this->getFieldValue($field['type']['slug']);
                        $insert['template_groups'][$temp_key]['fields'][$t_f_key]['content'] = $value;
                    }
                }
            }


            $request= new \Illuminate\Http\Request($insert);

            $db_item = $this->createContent($request);

            $list[$i] = $db_item->toArray();

        }

        return $list;


    }
    //-----------------------------------------------------------------
    public function getFieldValue($slug, $current_value=null)
    {
        $faker = \Faker\Factory::create();
        $value = null;

        switch ($slug)
        {
            case 'title':
            case 'sub-title':
            case 'text':
                $value = $faker->sentence;
                break;
            case 'slug':
                $value = $faker->slug;
                break;
            case 'excerpt':
                $value = $faker->paragraph;
                break;
            case 'content':
            case 'textarea':
            case 'editor':
                $value = $faker->text(500);
                break;
            case 'seo-meta-tags':

                $value = [
                    "seo_title"=>[
                        "name"=> "SEO Title",
                        "type"=> "text",
                        "maxlength"=> 70,
                        "content"=> $faker->sentence
                    ],
                    "seo_description"=>[
                        "name"=> "SEO Meta Description",
                        "type"=> "text",
                        "maxlength"=> 70,
                        "content"=> $faker->paragraph
                    ],
                    "seo_keywords"=>[
                        "name"=> "SEO Meta Keywords",
                        "type"=> "text",
                        "maxlength"=> 70,
                        "content"=> $faker->sentence
                    ]
                ];

                break;
            default:
                $value = $current_value;
                break;
        }

        return $value;
    }
    //-----------------------------------------------------------------
    public function createContent($request)
    {


        $inputs = $request->all();


        $item = new Content();


        $fillable['name'] = $inputs['name'];
        $fillable['slug'] = \Str::slug($inputs['name']);
        $fillable['permalink'] = $fillable['slug'];
        $fillable['vh_cms_content_type_id'] = $request->vh_cms_content_type_id;
        $fillable['vh_theme_id'] = $request->vh_theme_id;
        $fillable['vh_theme_template_id'] = $request->vh_theme_template_id;
        $fillable['is_published_at'] = \Carbon::now();
        if(!$request->has('status'))
        {
            $fillable['status'] = 'published';
        } else{
            $fillable['status'] = $request->status;
        }

        $item->fill($fillable);
        $item->save();


        foreach ($inputs['content_groups'] as $group)
        {

            foreach ($group['fields'] as $field)
            {
                $content_field = [];
                $content_field['vh_cms_content_id'] = $item->id;
                $content_field['vh_cms_form_group_id'] = $field['vh_cms_form_group_id'];
                $content_field['vh_cms_form_field_id'] = $field['id'];

                if(isset($field['content']))
                {
                    $content_field['content'] = $field['content'];
                    $store_field = new ContentFormField();
                    $store_field->fill($content_field);
                    $store_field->save();
                }

            }

        }

        if(isset($inputs['template_groups']) && is_array($inputs['template_groups']))
        {
            foreach ($inputs['template_groups'] as $group)
            {

                foreach ($group['fields'] as $field)
                {
                    $content_field = [];
                    $content_field['vh_cms_content_id'] = $item->id;
                    $content_field['vh_cms_form_group_id'] = $field['vh_cms_form_group_id'];
                    $content_field['vh_cms_form_field_id'] = $field['id'];

                    if(isset($field['content']))
                    {
                        $content_field['content'] = $field['content'];
                        $store_field = new ContentFormField();
                        $store_field->fill($content_field);
                        $store_field->save();
                    }

                }

            }
        }

        return $item;

    }
    //-----------------------------------------------------------------
    //-----------------------------------------------------------------
    //-----------------------------------------------------------------



}
