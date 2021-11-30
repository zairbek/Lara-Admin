<?php

namespace Future\LaraAdmin\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 * @property null|string 	$first_name
 * @property null|string 	$last_name
 * @property null|string 	$second_name
 * @property string 		$login
 * @property null|int 		$phone_number
 * @property string 		$email
 * @property string 		$password
 * @property bool 			$active
 * @property null|Carbon 	$birthday
 * @property null|array 	$properties
 * @property Collection     $roles
 * @property Media     		$avatar
 *
 * @package App
 */
class User extends Authenticatable implements HasMedia
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use HasRoles;
	use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'second_name',
        'login',
        'phone_number',
        'email',
        'password',
        'avatar',
        'birthday',
        'properties'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'active' => 'bool',
        'birthday' => 'datetime',
        'properties' => 'array',
    ];

	public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = app(Hasher::class)->make($value);
	}

    public function getName(): string
    {
        $name = '';

        switch (true) {
            case (bool) $this->first_name:
                $name .= $this->first_name . ' ';
            case (bool) $this->last_name:
                $name .= $this->last_name . ' ';
            case (bool) $this->second_name:
                $name .= $this->second_name;
        }

        if (! (bool) $name) {
            $name .= $this->email;
        }

        return $name;
    }

	public function setAvatarAttribute($value)
	{
		$this->addMedia($value)->toMediaCollection('avatar');
    }

	public function getAvatarAttribute(): ?Media
	{
		return $this->load('media')->getMedia('avatar')->first();
    }

	public function getAvatarUrl(): ?string
	{
		return $this->avatar ? $this->avatar->getUrl() : null;
    }

	public function registerMediaCollections(): void
	{
		$this->addMediaCollection('avatar')->singleFile();
	}
}
