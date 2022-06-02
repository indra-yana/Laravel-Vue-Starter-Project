<?php

namespace App\Src\Services\Eloquent;

use App\Models\Post;
use App\Models\User;
use App\Src\Base\Constant;
use App\Src\Base\IBaseService;
use App\Src\Helpers\UploadPath;
use App\Src\Services\Upload\UploadService;
use App\Src\Validators\PostValidator;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostService implements IBaseService {

    protected $post;
    protected $validator;

    public function __construct(Post $post, PostValidator $validator) 
    {
        $this->post = $post;
        $this->validator = $validator;
    }

    /**
     * Get the instance of class.
     *
     * @return object
     */
    public static function getInstance()
    {
        return new static(new Post(), new PostValidator());
    }

    /**
     * Get the model or data result as defined.
     *
     * @return array
     */
    public function formatResult($model)
    {
        return $model->toArray();
    }
    
    /**
     * Get the user post list with pagination
     *
     * @param string $user_id
     * @return array
     */
    public function getUserPost(string $user_id)
    {        
        $user = User::find($user_id);
        if (!$user) {
            throw new NotFoundHttpException(__('Data or resource can\'t be found'), null, 404);
        }
        
        $post = $user->post()->paginate(10);

        return [
            'meta' => $resource = new JsonResource($post),
            'post' => $resource->collection($post),
        ];
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

        $model = $this->post->create([
            'title' => ucwords($data['title']),
            'body' => $data['body'],
            'status' => $data['status'],
            'is_pinned' => $data['is_pinned'],
            'user_id' => $data['user_id'],
        ]);

        if (@$data['thumbnail']) {
            $config = [
                "prefix" => "post",
                "path" => UploadPath::post($model->id),
                "file" => @$data["thumbnail"],
            ];
    
            $model->thumbnail = UploadService::getInstance()->upload($config);
            $model->save();
        }

        return $this->formatResult($model);
    }
    
}