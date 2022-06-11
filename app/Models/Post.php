<?php

namespace App\Models;

use App\Src\Traits\Truncateable;
use App\Src\Traits\UUIDPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use AlAminFirdows\LaravelEditorJs\Facades\LaravelEditorJs;

class Post extends Model
{
    use HasFactory, UUIDPrimaryKey, Truncateable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime', 
        'updated_at' => 'datetime',
        'is_pinned' => 'bool',
        'body' => 'json',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'formated_status',
        'formated_created_at',
        'formated_updated_at',
        'formated_body',
    ];

    /**
     * The accessors to get thumbnail with full path.
     *
     * @param string|null $value
     * 
     * @return string
     */
    public function getThumbnailAttribute($value)
    {
        return $value ? asset("images/post/{$this->id}/{$value}") : null;
    }

    /**
     * The accessors to get formated status.
     *
     * @param int $value
     * 
     * @return string
     */
    public function getFormatedStatusAttribute($value)
    {
        switch ($this->status) {
            case 0:
                return __('Draft');
            case 1:
                return __('Published');
            default:
                return __('Undefined');
        }
    }
    
    /**
     * The accessors to get formated created_at.
     *
     * @param int $value
     * 
     * @return string
     */
    public function getFormatedCreatedAtAttribute($value)
    {
        return $this->created_at->translatedFormat('l, d-m-Y');
    }

    /**
     * The accessors to get formated updated_at.
     *
     * @param int $value
     * 
     * @return string
     */
    public function getFormatedUpdatedAtAttribute($value)
    {
        return $this->updated_at->translatedFormat('l, d-m-Y');
    }

    /**
     * The accessors to get formated body.
     *
     * @param int $value
     * 
     * @return string
     */
    public function getFormatedBodyAttribute($value)
    {
        try {
            return $this->body ? LaravelEditorJs::render(json_encode($this->body)) : null;
        } catch (\Throwable $th) {
            //throw $th;
            return null;
        }
    }
    
    /**
     * The model relation belongsTo User.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
