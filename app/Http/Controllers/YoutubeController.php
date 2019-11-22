<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\YoutubePlaylist;
use Illuminate\View\View;

class YoutubeController extends Controller
{
    /**
     * @param User $user
     * @return JsonResponse
     */
    public function index(User $user)
    {
      $list = YoutubePlaylist::with('paykeeper')
        ->whereStatus('not_shown')
        ->whereHas('paykeeper', function ($query) {
          return $query->whereStatus('paid');
        })
        ->whereUserId($user->id)
        ->get();

      return $this->success($list);
    }

    /**
     * @param User $user
     * @param string $token
     * @param $id
     * @return JsonResponse
     */
    public function destroy(User $user, string $token, $id)
    {
      YoutubePlaylist::whereStatus('not_shown')
        ->whereUserId($user->id)
        ->whereVideoId($id)
        ->limit(1)
        ->update(['status' => 'shown']);

      return $this->success(['message' => '=)']);
    }

    /**
     * @param User $user
     * @param string $token
     * @return Factory|View
     */
    public function playVideo(User $user, string $token)
    {
      return view('playVideo', compact('user', 'token'));
    }
}
