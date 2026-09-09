<?php
namespace ElegenceIO\Exceptions\Listeners;
use ElegenceIO\Exceptions\Exceptions\FileNotFoundException;
use Throwable;
use Psr\Log\LoggerInterface;

class FileNotFoundListener
{

    public function __construct(private LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    public function support(Throwable $e):bool
    {
        return $e  instanceof FileNotFoundException;
    }

     public function handle(Throwable $e): void
    {
        if (!$e instanceof FileNotFoundException) {
            return;
        }

        http_response_code(404);
        echo json_encode([
            'error' => 'File not found',
            'message' => $e->getMessage(),
            "line"=>__LINE__,
            "FILE"=>__FILE__,
            'code' => $e->getCode(),
        ],JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }
}