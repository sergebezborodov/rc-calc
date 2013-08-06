<?php


class FacebookOAuthServiceEx extends FacebookOAuthService
{
    protected function fetchAttributes()
    {
        $info = (object) $this->makeSignedRequest('https://graph.facebook.com/me');

        $this->attributes['id'] = $info->id;
        $this->attributes['name'] = $info->name;
        $this->attributes['url'] = $info->link;
        if (!empty($info->{'location'})) {
            $this->attributes['city'] = $info->{'location'}->{'name'};
        }
        if (!empty($info->{'email'})) {
            $this->attributes['email'] = $info->{'email'};
        }
    }
}
