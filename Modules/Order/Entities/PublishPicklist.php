<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PublishPicklist extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected $table = 'published_picklists';

}
