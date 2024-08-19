<?php

namespace App\Repositories\Law;

class LawService {
    public function __construct(protected LawRepositoryInterface $repository) {}
}
