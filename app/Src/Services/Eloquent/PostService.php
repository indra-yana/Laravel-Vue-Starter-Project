<?php

namespace App\Src\Services\Eloquent;

use App\Models\Post;
use App\Models\User;
use App\Src\Base\IBaseService;
use App\Src\Helpers\UploadPath;
use App\Src\Services\Upload\UploadService;
use App\Src\Validators\PostValidator;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostService implements IBaseService {

    protected $model;
    protected $validator;

    public function __construct(Post $model, PostValidator $validator) 
    {
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
        return new static(new Post(), new PostValidator());
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
     * Get the user post list with pagination
     *
     * @param string $user_id
     * @return array
     */
    public function userPost(string $user_id)
    {        
        $user = User::find($user_id);
        if (!$user) {
            throw new NotFoundHttpException(__('message.data_notfound'), null, 404);
        }
        
        $post = $user->post()->with('user')->latest()->paginate(10);

        return [
            'meta' => $resource = new JsonResource($post),
            'posts' => $resource->collection($post),
        ];
    }

    /**
     * Retrieve a model.
     *
     * @param string $id
     * @return object
     */
    public function show(string $id)
    {
        $this->validator->validateID($id);

        return $this->model->find($id);
    }

    /**
     * Retrieve detail of the model.
     *
     * @param string $id
     * @return object
     */
    public function detail(string $id)
    {
        $this->validator->validateID($id);

        $model = $this->model->with('user')->find($id);

        return $model;
    }

    /**
     * Get data for datatable format.
     *
     * @param array $data
     * @return \Yajra\DataTables\Facades\DataTables
     */
    public function dtTableJson(array $data)
    {
        $model = $this->model->query()->where('user_id', $data['user_id']);

        return datatables()->of($model)->rawColumns(['formated_body'])->toJson();
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

        $model = $this->model->create([
            'title' => ucwords($data['title']),
            'body' => json_decode($data['body']),
            'status' => $data['status'],
            'is_pinned' => $data['is_pinned'],
            'user_id' => $data['user_id'],
        ]);

        if (@$data['thumbnail']) {
            $config = [
                "prefix" => "post",
                "path" => UploadPath::post($model->id),
                "file" => $data["thumbnail"],
            ];
    
            $model->thumbnail = UploadService::getInstance()->upload($config);
            $model->save();
        }

        return new JsonResource($model);
    }

    /**
     * Update an existing data.
     *
     * @param array $data
     * @return array
     */
    public function update(array $data)
    {
        $this->validator->validateUpdate($data);

        $model = $this->model->where(['id' => $data['id'], 'user_id' => $data['user_id']])
                            ->update([
                                'title' => ucwords($data['title']),
                                'body' => $data['body'],
                                'status' => $data['status'],
                                'is_pinned' => $data['is_pinned'],
                            ]);

        if (@$data['thumbnail']) {
            // $model = $this->show($data['id']);   // Uncomment this if needed
            $config = [
                "prefix" => "post",
                "path" => UploadPath::post($model->id),
                "file" => $data["thumbnail"],
            ];

            if ($model->thumbnail) {
                $config["old_file"] = UploadPath::post("{$model->id}/{$model->thumbnail}");
            }
    
            $model->thumbnail = UploadService::getInstance()->upload($config);
            $model->save();
        }

        return $this->formatResult($model);
    }

    /**
     * Delete an existing data.
     *
     * @param string $id
     * @return bool
     */
    public function delete(string $id)
    {
        $model = $this->show($id);

        // Delete old post thumbnail
        $oldFile = UploadPath::post("{$model->id}/{$model->thumbnail}");
        UploadService::getInstance()->delete($oldFile);

        return $model->delete();
    }
    
}