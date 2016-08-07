<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Admin
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property integer $status
 * @property integer $active
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereDeletedAt($value)
 */
	class Admin extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Category
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property integer $sort
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\Models\Category $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $children
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereSort($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereDeletedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property integer $id
 * @property string $name
 * @property string $sku
 * @property integer $category_id
 * @property float $org_price
 * @property float $dsc_price
 * @property integer $stock
 * @property string $introduction
 * @property string $description
 * @property integer $icon_id
 * @property string $banner
 * @property integer $sort
 * @property integer $snapshot
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\Models\Category $category
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereSku($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereOrgPrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereDscPrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereStock($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereIntroduction($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereIconId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereBanner($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereSort($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereSnapshot($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereDeletedAt($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Cart
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $user_id
 * @property integer $count
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart whereProductId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart whereCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart whereDeletedAt($value)
 */
	class Cart extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereDeletedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Order
 *
 * @property integer $id
 * @property string $orderid
 * @property integer $status
 * @property float $sum_price
 * @property integer $user
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereOrderid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereSumPrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereDeletedAt($value)
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PictureType
 *
 * @property integer $id
 * @property string $dir
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PictureType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PictureType whereDir($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PictureType whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PictureType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PictureType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PictureType whereDeletedAt($value)
 */
	class PictureType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Picture
 *
 * @property integer $id
 * @property integer $type_id
 * @property string $name
 * @property string $path
 * @property string $md5
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\Models\PictureType $PictureType
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Picture whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Picture whereTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Picture whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Picture wherePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Picture whereMd5($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Picture whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Picture whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Picture whereDeletedAt($value)
 */
	class Picture extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Sku
 *
 * @property integer $id
 * @property string $prefix
 * @property integer $count
 * @property \Carbon\Carbon $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sku whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sku wherePrefix($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sku whereCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sku whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sku whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sku whereUpdatedAt($value)
 */
	class Sku extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereDeletedAt($value)
 */
	class User extends \Eloquent {}
}

