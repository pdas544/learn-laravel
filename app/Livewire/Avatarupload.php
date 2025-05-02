<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class Avatarupload extends Component
{
    use WithFileUploads;

    public $avatar;

    public function save(){
        if(!auth()->check()){
            abort(403, 'Unauthorized action.');
        }

        $user = auth()->user();

        $fileName = $user->id . '-' . uniqid() . '.jpg';

        //using external library: intervention/image
        $manager = new ImageManager(new Driver());
        $image = $manager->read($this->avatar);
        $imageData = $image->cover(128, 128)->toJpeg();
        Storage::disk('public')->put('avatars/' . $fileName, $imageData);

        $oldAvatar = $user->avatar;

        $user->avatar = $fileName;
        $user->save();

        // Delete old avatar if it exists
        if($oldAvatar != "/fallback-avatar.jpg"){
            Storage::disk('public')->delete(str_replace("/storage/","",$oldAvatar)); 
        }

        session()->flash('success', 'Avatar uploaded successfully');
        return $this->redirect("/manage-avatar",navigate:true);
    }
    public function render()
    {
        return view('livewire.avatarupload');
    }
}
