<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use JWTAuth;
use App\User;
use TwitchApi;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @SWG\Swagger(
 *   schemes={"http"},
 *   host="stream.local",
 *   basePath="/",
 *   @SWG\Info(
 *     title="Donation Support API",
 *     version="1.0.0"
 *   )
 * )
 */

/**
 * @SWG\Definition(
 *  definition="MainSettings",
 *  @SWG\Property(
 *      property="Donate",
 *      type="object",
 *      @SWG\Property(property="commission", type="integer"),
 *      @SWG\Property(property="minAmount", type="integer"),
 *      @SWG\Property(property="minCommissionAmount", type="integer"),
 *      @SWG\Property(property="percent", type="integer"),
 *  ),
 *  @SWG\Property(
 *      property="DonateForm",
 *      type="object",
 *      @SWG\Property(
 *          property="btnBack",
 *          type="object",
 *          @SWG\Property(property="bgColor", type="string"),
 *          @SWG\Property(property="flat", type="boolean"),
 *          @SWG\Property(property="fontFamily", type="string"),
 *          @SWG\Property(property="icon", type="string"),
 *          @SWG\Property(property="light", type="boolean"),
 *          @SWG\Property(property="size", type="integer"),
 *      ),
 *      @SWG\Property(
 *          property="btnCanel",
 *          type="object",
 *          @SWG\Property(property="bgColor", type="string"),
 *          @SWG\Property(property="flat", type="boolean"),
 *          @SWG\Property(property="fontFamily", type="string"),
 *          @SWG\Property(property="icon", type="string"),
 *          @SWG\Property(property="light", type="boolean"),
 *          @SWG\Property(property="size", type="integer"),
 *          @SWG\Property(property="text", type="string"),
 *      ),
 *      @SWG\Property(
 *          property="btnDonat",
 *          type="object",
 *          @SWG\Property(property="bgColor", type="string"),
 *          @SWG\Property(property="color", type="string"),
 *          @SWG\Property(property="flat", type="boolean"),
 *          @SWG\Property(property="fontFamily", type="string"),
 *          @SWG\Property(property="icon", type="string"),
 *          @SWG\Property(property="light", type="boolean"),
 *          @SWG\Property(property="size", type="integer"),
 *          @SWG\Property(property="text", type="string"),
 *      ),
 *      @SWG\Property(
 *          property="btnNext",
 *          type="object",
 *          @SWG\Property(property="bgColor", type="string"),
 *          @SWG\Property(property="color", type="string"),
 *          @SWG\Property(property="flat", type="boolean"),
 *          @SWG\Property(property="fontFamily", type="string"),
 *          @SWG\Property(property="icon", type="string"),
 *          @SWG\Property(property="light", type="boolean"),
 *          @SWG\Property(property="size", type="integer"),
 *          @SWG\Property(property="text", type="string"),
 *      ),
 *      @SWG\Property(
 *          property="header",
 *          type="object",
 *          @SWG\Property(property="bgColor", type="string"),
 *          @SWG\Property(property="color", type="string"),
 *          @SWG\Property(property="fontFamily", type="string"),
 *          @SWG\Property(property="fontSize", type="integer"),
 *      ),
 *      @SWG\Property(
 *          property="main",
 *          type="object",
 *          @SWG\Property(property="bg", type="string"),
 *          @SWG\Property(property="bgColor", type="string"),
 *          @SWG\Property(property="bgImage", type="string"),
 *          @SWG\Property(property="bgVideo", type="string"),
 *          @SWG\Property(property="justify", type="string"),
 *          @SWG\Property(property="light", type="boolean"),
 *          @SWG\Property(property="minDonate", type="integer"),
 *      ),
 *      @SWG\Property(
 *          property="other",
 *          type="object",
  *         @SWG\Property(property="donatevideolimit", type="integer"),
 *      ),
 *  ),
 *  @SWG\Property(
 *      property="pushDonate",
 *      type="object",
 *      @SWG\Property(
 *          property="amount",
 *          type="object",
 *          @SWG\Property(property="color", type="string"),
 *          @SWG\Property(property="font", type="string"),
 *          @SWG\Property(property="size", type="integer"),
 *      ),
 *      @SWG\Property(
 *          property="attachment",
 *          type="object",
 *          @SWG\Property(property="src", type="string"),
 *      ),
 *      @SWG\Property(
 *          property="image",
 *          type="object",
 *          @SWG\Property(property="color", type="string"),
 *          @SWG\Property(property="size", type="integer"),
 *          @SWG\Property(property="src", type="string"),
 *          @SWG\Property(property="tile", type="boolean"),
 *      ),
 *      @SWG\Property(
 *          property="main",
 *          type="object",
 *          @SWG\Property(property="bgColor", type="string"),
 *          @SWG\Property(property="duration", type="integer"),
 *          @SWG\Property(
 *              property="grid",
 *              type="object",
 *              @SWG\Property(property="image", type="string"),
 *              @SWG\Property(property="xs6", type="boolean"),
 *              @SWG\Property(property="xs12", type="boolean"),
 *          ),
 *          @SWG\Property(
 *              property="sound",
 *              type="object",
 *              @SWG\Property(property="src", type="string"),
 *              @SWG\Property(property="volume", type="integer"),
 *          ),
 *      ),
 *      @SWG\Property(
 *          property="message",
 *          type="object",
 *          @SWG\Property(property="color", type="string"),
 *          @SWG\Property(property="font", type="string"),
 *          @SWG\Property(property="size", type="integer"),
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          type="object",
 *          @SWG\Property(property="color", type="string"),
 *          @SWG\Property(property="font", type="string"),
 *          @SWG\Property(property="size", type="integer"),
 *      ),
 *      @SWG\Property(
 *          property="position",
 *          type="object",
 *          @SWG\Property(
 *              property="attachment",
 *              type="object",
 *              @SWG\Property(property="angle", type="integer"),
 *              @SWG\Property(property="classPrefix", type="string"),
 *              @SWG\Property(property="height", type="integer"),
 *              @SWG\Property(property="id", type="string"),
 *              @SWG\Property(property="scaleX", type="integer"),
 *              @SWG\Property(property="scaleY", type="integer"),
 *              @SWG\Property(property="width", type="integer"),
 *              @SWG\Property(property="x", type="integer"),
 *              @SWG\Property(property="y", type="integer"),
 *          ),
 *          @SWG\Property(
 *              property="counter",
 *              type="object",
 *              @SWG\Property(property="angle", type="integer"),
 *              @SWG\Property(property="classPrefix", type="string"),
 *              @SWG\Property(property="height", type="integer"),
 *              @SWG\Property(property="id", type="string"),
 *              @SWG\Property(property="scaleX", type="integer"),
 *              @SWG\Property(property="scaleY", type="integer"),
 *              @SWG\Property(property="width", type="integer"),
 *              @SWG\Property(property="x", type="integer"),
 *              @SWG\Property(property="y", type="integer"),
 *          ),
 *          @SWG\Property(
 *              property="message",
 *              type="object",
 *              @SWG\Property(property="angle", type="integer"),
 *              @SWG\Property(property="classPrefix", type="string"),
 *              @SWG\Property(property="height", type="integer"),
 *              @SWG\Property(property="id", type="string"),
 *              @SWG\Property(property="scaleX", type="integer"),
 *              @SWG\Property(property="scaleY", type="integer"),
 *              @SWG\Property(property="width", type="integer"),
 *              @SWG\Property(property="x", type="integer"),
 *              @SWG\Property(property="y", type="integer"),
 *          ),
 *          @SWG\Property(
 *              property="title",
 *              type="object",
 *              @SWG\Property(property="angle", type="integer"),
 *              @SWG\Property(property="classPrefix", type="string"),
 *              @SWG\Property(property="height", type="integer"),
 *              @SWG\Property(property="id", type="string"),
 *              @SWG\Property(property="scaleX", type="integer"),
 *              @SWG\Property(property="scaleY", type="integer"),
 *              @SWG\Property(property="width", type="integer"),
 *              @SWG\Property(property="x", type="integer"),
 *              @SWG\Property(property="y", type="integer"),
 *          ),
 *      ),
 *      @SWG\Property(
 *          property="video",
 *          type="object",
 *          @SWG\Property(property="src", type="string"),
 *      ),
 *    ),
 *      @SWG\Property(
 *          property="subscribers",
 *          type="object",
 *          @SWG\Property(property="costPremium", type="integer"),
 *      )
 *    ),
 *  ),
 *
 * @SWG\Definition(
 *  definition="UserProfile",
 *  @SWG\Property(property="accout_type", type="string"),
 *  @SWG\Property(property="avatar", type="string"),
 *  @SWG\Property(property="blocked_at", type="string"),
 *  @SWG\Property(property="created_at", type="string"),
 *  @SWG\Property(property="deleted_at", type="string"),
 *  @SWG\Property(property="email", type="string"),
 *  @SWG\Property(property="id", type="integer"),
 *  @SWG\Property(property="is_vk", type="integer"),
 *  @SWG\Property(property="login", type="string"),
 *  @SWG\Property(property="name", type="string"),
 *  @SWG\Property(property="profile_mode", type="string"),
 *  @SWG\Property(property="settings", type="object"),
 *  @SWG\Property(property="social_google", type="boolean"),
 *  @SWG\Property(property="social_twitch", type="boolean"),
 *  @SWG\Property(property="social_vkontakte", type="boolean"),
 *  @SWG\Property(property="status", type="string"),
 *  @SWG\Property(property="stream_hash_link", type="string"),
 *  @SWG\Property(property="twitch_id", type="integer"),
 *  @SWG\Property(property="type", type="object"),
 *  @SWG\Property(property="updated_at", type="string"),
 * ),
 *
 * @SWG\Definition(
 *  definition="FetchLinks",
 *  @SWG\Property(
 *      property="[]",
 *      type="array",
*         @SWG\Items(
*             type="object",
*             @SWG\Property(property="link", type="string"),
*             @SWG\Property(property="name", type="string"),
*             @SWG\Property(property="types", type="string"),
*         ),
 *  ),
 * ),
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $request;

    /**
     * Controller constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $data
     * @param int $check_numeric
     * @return JsonResponse
     */
    public function success($data, $check_numeric = JSON_NUMERIC_CHECK)
    {
        return response()->json($data, 200, [], $check_numeric);
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    public function fail($data)
    {
        if (!is_array($data)) {
            $data = ['errors' => $data];
        }
        return response()->json(['errors' => [$data]], 400);
    }

    /**
     * @return User|null
     */
    protected function user(): ?User
    {
        static $user;

        if (!JWTAuth::getToken()) {
            return null;
        }
        if ($user) {
            return $user;
        }
        $user = JWTAuth::parseToken()->authenticate();

        return $user;
    }

    /**
     * @return mixed
     */
    protected function getUser()
    {
        $user = $this->request->user()->info['twitch'];
        TwitchApi::setToken($user['token']);

        return $user;
    }
}
