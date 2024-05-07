<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *      title="Laravel API",
 *      version="1.0.0",
 *      description="API Description",
 *      @OA\Contact(
 *          email="benjamin.m@coqipt.fr"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 */

class ApiController extends Controller
{
    /**
     * Display a welcome message.
     *
     * @OA\Get(
     *     path="/api/v1/welcome",
     *     summary="Display a welcome message",
     *     tags={"Pages"},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="title", type="string", example="Stock Management App")
     *          )
     *      )
     * )
     */
    public function index()
    {
        return response()->json([
            'title' => '<h2>Stock Management App</h2>
<p>Please log in to manage inventory.</p>',
        ]);
    }
}
