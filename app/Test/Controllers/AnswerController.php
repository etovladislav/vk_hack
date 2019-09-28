<?php

namespace App\Test\Controllers;

use App\Root\Http\Controllers\Controller;
use App\Test\Services\AnswerService;
use Illuminate\Http\Request;
use VK\Exceptions\VKApiException;

final class AnswerController extends Controller
{

    /** @var AnswerService */
    private $answerService;
    /** @var Request */
    private $request;

    /**
     * AnswerController constructor.
     * @param AnswerService $answerService
     * @param Request $request
     */
    public function __construct(AnswerService $answerService, Request $request)
    {
        $this->answerService = $answerService;
        $this->request = $request;
    }


    public function save()
    {
        $this->validate($this->request, [
            'access_token' => 'required',
            'answers' => 'required|array',
            'answers.*' => 'integer'
        ]);
        if (!empty($errors)) {
            return response()->json(['message' => 'fail validation'], 400);
        }

        $accessToken = $this->request->get('access_token');
        $answers = $this->request->get('answers');

        try {
            $this->answerService->saveAnswers($accessToken, $answers);
        } catch (VKApiException $exception) {
            return response()->json(['message' => $exception->getMessage()], 400);
        }

        return response()->json([
            'message' => 'success'
        ]);
    }

}
