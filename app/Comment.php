<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use Laravelista\Comments\Commentable;

class Comment extends Model
{
	use SoftDeletes;

}
