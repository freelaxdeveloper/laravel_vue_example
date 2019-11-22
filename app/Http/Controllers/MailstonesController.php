<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\{Badge, Animation, Milestone, MusicMilestone};
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;
use App\User;

class MailstonesController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function closets()
    {
        if (!$this->user()->id) {
            return response()->json(['status' => 'error'], 401);
        }

        return $this->success(
            Milestone::getClosestMilestone($this->user()->id, $this->request->who_id)
                ->with(['badges', 'animations', 'music'])->first()
        );
    }

    /**
     * @return JsonResponse
     */
    public function add()
    {
        $validator = Validator::make($this->request->all(), [
            'donate' => 'required|integer',
            'badges' => 'nullable|array',
            'music' => 'nullable|array',
            'animations' => 'nullable|array',
        ])->validate();

        $badges = Badge::find($this->request->badges);
        $animations = Animation::whereIn('animate', $this->request->animations)->get();

        $milestone = Milestone::create([
            'user_id' => $this->user()->id,
            'donate' => $this->request->donate
        ]);

        $milestone->badges()->attach($badges->pluck('id'));
        $milestone->animations()->attach($animations->pluck('id'));

        $music = [];
        foreach ($this->request->music as $src) {
            $music[] = [
                'milestone_id' => $milestone->id,
                'src' => $src,
            ];
        }
        MusicMilestone::insert($music);

        $milestone = Milestone::withCount(['badges', 'animations', 'music'])->find($milestone->id);

        return $this->success($milestone);
    }

    /**
     * @return JsonResponse
     */
    public function list()
    {
        $milestones = Milestone::withCount(['badges', 'animations', 'music'])
            ->whereUserId($this->user()->id)
            ->get();

        return $this->success($milestones);
    }

    /**
     * @param Milestone $milestone
     * @return JsonResponse
     * @throws Exception
     */
    public function remove(Milestone $milestone)
    {
        $milestone->badges()->detach();
        $milestone->animations()->detach();
        $milestone->music()->delete();

        if ($milestone->delete()) {
            return $this->success('Майлстоун успешно удалён');
        }

        return $this->fail('Не удалось удалить');
    }

    /**
     * @return JsonResponse
     */
    public function badges()
    {
        $badges = Badge::get();
        return $this->success($badges);
    }

    /**
     * @param User $user
     * @param Request $request
     * @return JsonResponse
     */
    public function badge(User $user, Request $request)
    {
        $badges = Badge::where('user_id', $request->loaded ? $user->id : null)->get();
        return $this->success($badges);
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function music(User $user)
    {
        $music = [];
        getMusic("storage/uploads/{$user->id}/milestone/sound/", $music);
        getMusic("storage/music/", $music);

        return $this->success($music);
    }

    /**
     * @return JsonResponse
     */
    public function animations()
    {
        $animations = Animation::get();
        return $this->success($animations);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function imageUpload(Request $request)
    {
        $validator = Validator::make($_FILES, [
            'file' => 'required|array',
            'file.tmp_name' => 'required|string',
            'file.name' => 'required|string',
        ])->validate();
        $user = $request->user();
        $file = $_FILES['file'];

        $path = "/storage/uploads/{$user->id}/milestone/badge";
        $dir = public_path($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $fileinfo = pathinfo($file['name']);
        $filename = 'badge_' . time() . '_' . rand(0, time()) . '_' . '.' .  $fileinfo['extension'];
        copy($file['tmp_name'], "{$dir}/{$filename}");

        return $this->success(['src' => "{$path}/{$filename}", 'name' => $filename]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function soundUpload(Request $request) {
        $validator = Validator::make($_FILES, [
            'file' => 'required|array',
            'file.tmp_name' => 'required|string',
            'file.name' => 'required|string',
        ])->validate();
        $user = $request->user();
        $file = $_FILES['file'];

        $mime = mime_content_type($file['tmp_name']);
        if (!in_array($mime, ['audio/mpeg', 'application/octet-stream'])) {
            return $this->fail(['Только музыка', $mime]);
        }

        $path = "storage/uploads/{$user->id}/milestone/sound";
        $dir = public_path($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $filename = str_slug(basename($file['name'], '.mp3')) . '.mp3';
        copy($file['tmp_name'], "{$dir}/{$filename}");

        return $this->success(['src' => "/{$path}/{$filename}", 'name' => $filename]);
    }
}
