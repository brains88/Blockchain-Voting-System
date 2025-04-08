<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Services\BlockchainService;

class BlockchainController extends Controller
{
    protected $blockchainService;

    public function __construct(BlockchainService $blockchainService)
    {
        $this->middleware('auth');
        $this->blockchainService = $blockchainService;
    }

    public function index()
    {
        $blocks = Block::latest()->get();
        $isValid = $this->blockchainService->validateChain();

        return view('blockchain.index', compact('blocks', 'isValid'));
    }
}