<?php

namespace Modules\Wpbox\Http\Controllers;

use App\Http\Requests\SocialMediaTokenRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Wpbox\Models\SocialMediaToken;

class SocialMediaTokenController extends Controller {
    public function index(): JsonResponse {
        $social_media_tokens = SocialMediaToken::all();
        if ($social_media_tokens->isEmpty()) {
            return response()->json(['message' => 'Social Media Tokens not found']);
        }
        return response()->json($social_media_tokens);
    }

    public function store(SocialMediaTokenRequest $request): JsonResponse {
        $socialMediaToken = SocialMediaToken::query()->create($request->validated());
        return response()->json($socialMediaToken);
    }


    public function show(int $id): JsonResponse|bool {
        $socialMediaToken = SocialMediaToken::query()->find($id);
        return response()->json($socialMediaToken);
    }

    public function update(SocialMediaTokenRequest $request, int $id): JsonResponse {
        try {
            DB::beginTransaction();

            $socialMediaToken = SocialMediaToken::query()->find($id);
            $socialMediaToken->fill($request->validated());
            $socialMediaToken->save();
            $resource = response()->json($socialMediaToken);

            DB::commit();
            return $resource;
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e, 404);
        }
    }

    public function destroy(int $id): JsonResponse {
        try {
            DB::beginTransaction();

            $socialMediaToken = SocialMediaToken::query()->find($id);
            $socialMediaToken->delete();

            DB::commit();
            $resource = response()->json('Social Media Token deleted successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e, 404);
        }
    }
}
