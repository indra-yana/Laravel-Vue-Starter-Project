<?php

namespace App\Src\Services\Eloquent;

use App\Models\User;
use App\Src\Base\IBaseService;
use App\Src\Helpers\UploadPath;
use App\Src\Services\Upload\UploadService;
use App\Src\Validators\UserValidator;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserService implements IBaseService {

    protected $model;
    protected $validator;

    public function __construct(User $model, UserValidator $validator) 
    {
        $this->model = $model;
        $this->validator = $validator;
    }

    /**
     * Get the instance of class.
     *
     * @return object
     */
    public static function getInstance()
    {
        return new static(new User(), new UserValidator());
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
     * Get the validator of this class.
     *
     * @return \App\Src\Validators\UserValidator
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * Retrieve a model.
     *
     * @param string $id
     * 
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
     * 
     * @return object
     */
    public function detail(string $id)
    {
        $this->validator->validateID($id);

        $model = $this->model->find($id);
        $post = $model->post()->paginate(10);

        return [
            'user' => $model,
            'post' => [
                'meta' => $resource = new JsonResource($post),
                'post' => $resource->collection($post),
            ]
        ];
    }

    /**
     * Create a new data for regsiter only.
     *
     * @param array $data
     * 
     * @return array
     */
    public function createForRegister(array $data)
    {
        $user = User::create([
            'name' => ucwords($data['name']),
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if (@$data["avatar"]) {
            $config = [
                "prefix" => "avatar",
                "path" => UploadPath::avatar($user->id),
                "file" => $data["avatar"],
            ];

            $user->avatar = UploadService::getInstance()->upload($config);
            $user->save();
        }

        return $user;
    }

    /**
     * Create a new data.
     *
     * @param array $data
     * 
     * @return array
     */
    public function create(array $data)
    {
        $user = User::create([
            'name' => ucwords($data['name']),
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if (@$data["avatar"]) {
            $config = [
                "prefix" => "avatar",
                "path" => UploadPath::avatar($user->id),
                "file" => $data["avatar"],
            ];

            $user->avatar = UploadService::getInstance()->upload($config);
            $user->save();
        }

        return $this->formatResult($user);
    }

    /**
     * Update existing data.
     *
     * @param array $data
     * 
     * @return array
     */
    public function update(array $data)
    {
        $this->validator->validateUpdate($data);

        $model = $this->model->where(['id' => $data['id']])
                            ->update([
                                'name' => ucwords($data['name']),
                                'username' => $data['username'],
                                'email' => $data['email'],
                                'password' => Hash::make($data['password']),
                            ]);

        if (@$data['avatar']) {
            // $model = $this->show($data['id']);   // Uncomment this if needed
            $config = [
                "prefix" => "avatar",
                "path" => UploadPath::avatar($model->id),
                "file" => $data["avatar"],
            ];

            if ($model->avatar) {
                $config["old_file"] = UploadPath::avatar("{$model->id}/{$model->avatar}");
            }
    
            $model->avatar = UploadService::getInstance()->upload($config);
            $model->save();
        }

        return $this->formatResult($model);
    }

    /**
     * Delete a model.
     *
     * @param string $id
     * 
     * @return bool
     */
    public function delete(string $id)
    {
        $model = $this->show($id);

        // Delete old post thumbnail
        $oldFile = UploadPath::avatar("{$model->id}/{$model->thumbnail}");
        UploadService::getInstance()->delete($oldFile);

        return $model->delete();
    }
    
}