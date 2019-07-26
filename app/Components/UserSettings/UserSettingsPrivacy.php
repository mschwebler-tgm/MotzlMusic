<?php

namespace App\Components\UserSettings;

class UserSettingsPrivacy
{
    const PROFILE_VISIBILITY_OPTIONS = ['everybody', 'friends', 'nobody'];

    private $incognito;
    private $likeActivity;
    private $onlineStatus;
    private $postUploads;
    private $showNameOnPosts;
    private $profileVisibility;

    public function __construct(
        $incognito,
        $likeActivity,
        $onlineStatus,
        $postUploads,
        $showNameOnPosts,
        $profileVisibility
    ) {
        $this->incognito = $incognito;
        $this->likeActivity = $likeActivity;
        $this->onlineStatus = $onlineStatus;
        $this->postUploads = $postUploads;
        $this->showNameOnPosts = $showNameOnPosts;
        $this->profileVisibility = $profileVisibility;
    }

    public static function fromArray(array $privacySettings)
    {
        return new self(
            $privacySettings['incognito'],
            $privacySettings['like_activity'],
            $privacySettings['online_status'],
            $privacySettings['post_uploads'],
            $privacySettings['show_name_on_posts'],
            $privacySettings['profile_visibility']
        );
    }

    public function toArray()
    {
        $settings = [];
        foreach (get_object_vars($this) as $key => $setting) {
            $settings[snake_case($key)] = $setting;
        }

        return $settings;
    }
}
