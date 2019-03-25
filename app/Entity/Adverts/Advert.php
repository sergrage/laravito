<?php

namespace App\Entity\Adverts;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Advert extends Model
{
    public const STATUS_DRAFT = 'draft';
    public const STATUS_MODERATION = 'moderation';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_CLOSED = 'closed';
    
    
    protected $table = 'advert_adverts';

    // это вместо fillabe. Разрешаем массово присваивать все кроме указанного здесь поля.
    protected $guarded = ['id'];
    
    // для автоматичесого заполнения меток времени/ так по умолчанию, поэтому можно удалить
    public $timestamps = true;
    
// преобразователь атрибутов. Если в базе один формат, то можно преобразовать сразу к datatime
// при выборе из БД сразу будут переконвертироваться
    protected $casts = [
      'published_at' => 'datatime',  
      'expires_at' => 'datatime',  
    ];
    
    public function isDraft(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }    
    
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }
}
