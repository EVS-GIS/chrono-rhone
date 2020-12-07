<?php namespace App\Http\Repositories\V1;

use App\Http\Repositories\BaseRepository;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;



class ImageRepository extends BaseRepository
{
	public function __construct(Image $image)
	{
		$this->model =$image;
  }
  
  public function index()
	{
		return $this->model->paginate(100);
  }

	public function upload($inputs)
	{
    $inputs["file"]->storeAs('', $inputs["file"]->getClientOriginalName());
    $image = $this->model->firstOrNew(
      [
        'filename'=> $inputs["file"]->getClientOriginalName(),
      ]
    );
    $image->fill($inputs);
    $image->save();
    if(isset($inputs["events"]))
    {
      $image->events()->sync($inputs["events"]);
    }
  }
  
  public function update($inputs, $id)
	{		
		$image = $this->model->find($id);
		$image->fill($inputs);
    $image->save();
    if(isset($inputs["events"]))
    {
      $image->events()->sync($inputs["events"]);
    }
	}

	public function destroy($filename)
	{
    Storage::delete($filename);
    $image = $this->model->where('filename',$filename);
    $image->delete();
	}
}