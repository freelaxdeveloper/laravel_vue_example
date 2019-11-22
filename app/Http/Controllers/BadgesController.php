<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Badge;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BadgesController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request)
    {
        $user = Auth::user();
        $imageProps = getimagesize($request->path);
        $badge = Badge::create([
            'user_id' => $user->id,
            'path' => $request->path,
            'size' => $imageProps[0] . 'x' . $imageProps[1],
            'name' => pathinfo($request->path,PATHINFO_FILENAME)
        ]);

        return $this->success($badge);
    }
}
