<?php

namespace App\Src\Services\Eloquent;

use App\Models\SocialLink;
use App\Src\Validators\SocialLinkValidator;
use Str;

class SocialLinkService {

    protected $model;
    protected $validator;
    protected $defaultSocialLink = [
        "facebook" => [
            'link' => null,
            'icon' => 'fab fa-facebook'
        ],
        "instagram" => [
            'link' => null,
            'icon' => 'fab fa-instagram'
        ],
        "twitter" => [
            'link' => null,
            'icon' => 'fab fa-twitter'
        ],
        "youtube" => [
            'link' => null,
            'icon' => 'fab fa-youtube'
        ],
        "discord" => [
            'link' => null,
            'icon' => 'fab fa-discord'
        ],
        "other" => [
            'link' => null,
            'icon' => 'fad fa-link'
        ],
    ];

    public function __construct(SocialLink $model, SocialLinkValidator $validator) {
        $this->model = $model;
        $this->validator = $validator;
    }

    /**
     * Get the instance of class.
     *
     * @param object $model
     * @return object
     */
    public static function getInstance()
    {
        return new static(new SocialLink(), new SocialLinkValidator());
    }

    /**
     * Get the result data of model.
     *
     * @return array
     */
    public function formatResult($model)
    {
        return $model->toArray();
    }

    /**
     * Create a new data.
     *
     * @param array $data
     * @return array
     */
    public function create(array $data)
    {
        $this->validator->validateCreate($data);
 
        $socials = $data["social_links"];
        $user_id = $data["user_id"];

        foreach ($socials as $name => $link) {
            if (in_array($name, array_keys($this->defaultSocialLink)) && $link['link'] != null) {
                $this->model->updateOrCreate(
                    ['user_id' => $user_id, 'name' => $name],
                    ['name' => $name, 'link' => $link['link']]
                );
            } else {
                $this->deleteSocialLink($user_id, $name);
            }
        }

        $links = $this->model->where("user_id", $user_id)->get();
        $socialLinks = [];

        foreach ($links as $link) {
            $name = $link->name;
            $socialLinks[$name] = [
                'link' => $link->link,
                'icon' => $this->defaultSocialLink[$name]['icon'],
            ];
        }

        foreach ($this->defaultSocialLink as $name => $value) {
            if (!in_array($name, array_keys($socialLinks))) {
                $socialLinks[$name] = [
                    'link' => $value['link'],
                    'icon' => $value['icon'],
                ];
            }
        }

        return [
            'social_links' => $socialLinks ?: $this->defaultSocialLink,
        ];
    }

    /**
     * Retrieve a model.
     *
     * @param string $userid
     * @return object
     */
    public function show(string $user_id)
    {
        $this->validator->validateUserID($user_id);

        $links = $this->model->where("user_id", $user_id)->get();
        $socialLinks = [];

        foreach ($links as $link) {
            $name = $link->name;
            if (in_array($name, array_keys($this->defaultSocialLink))) {
                $socialLinks[$name] = [
                    'link' => $link->link,
                    'icon' => $this->defaultSocialLink[$name]['icon'],
                ];
            } else {
                $this->deleteSocialLink($user_id, $name);
            }
        }

        foreach ($this->defaultSocialLink as $name => $value) {
            if (!in_array($name, array_keys($socialLinks))) {
                $socialLinks[$name] = [
                    'link' => $value['link'],
                    'icon' => $value['icon'],
                ];
            }
        }

        return [
            'social_links' => $socialLinks ?: $this->defaultSocialLink,
        ];
    }

    /**
     * Delete an existing data.
     *
     * @param string $id
     * @return bool
     */
    public function deleteSocialLink($userid, $name)
    {
        $this->model->where(["user_id" => $userid, "name" => $name])->delete();
    }

}