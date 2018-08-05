<?php
namespace App\Provider;

interface ContainerDefinitionInterface
{
    /**
     * 의존성 정의에 사용할 설정의 키를 반환한다.
     *
     * @return 설정의 키
     */
    public function getSettingsKey(): string;

    /**
     * Dependency Injection을 위한 의존성을 정의한다.
     *
     * @return 의존성 정의
     */
    public function __invoke(): array;
}
