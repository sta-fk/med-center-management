<?php declare(strict_types=1);

namespace App\ApiClient\EventSubscriber;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

final class AddPaginationHeaders
{
    public function __construct(
        private PaginatorInterface  $paginator,
    ) {}

    public function onKernelResponse(ResponseEvent $event): void
    {
        $response = $event->getResponse();
        $request = $event->getRequest();

        if (
            is_array($items = json_decode($response->getContent()))
            && strpos($request->getPathInfo(), 'admin')
        ) {

            $limit = $request->query->get('range') ?? null;

            $paginator = $this->paginator->paginate(
                $items,
                $request->query->getInt('page', 1),
                is_null($limit) ? 10 : json_decode($limit)[1] + 1
            );

            $response->headers->add([
                'Content-Range' => \sprintf('%u-%u/%u',
                    $paginator->getItems(),
                    $paginator->getItemNumberPerPage(),
                    $paginator->getTotalItemCount()),
            ]);
        }
    }
}
