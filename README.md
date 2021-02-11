# Модульный скелетон для Symfony

Привожу тут слегка причёсанную цитату [@fesor](https://github.com/fesor) ([оригинал](https://t.me/symfony_php/202422)):

> Модуль — это единица кода. Например, файл, директория, пакет, класс или неймспейс.
> Модули "хорошие", когда между ними низкая связанность (low coupling) и внутри высокое зацепление (high cohesion).
> С ростом проекта растет необходимость изоляции этих модулей. Простой риск менеджмент — ты не можешь случайно сломать фичу, если ты её не трогал.
> Единственный верный вариант в этом плане — рассматривать фичи как модули и искать у них границы, выделять точки расширения, чтобы минимизировать необходимость их "менять", следить за пересечениями границ.
>
> Если проект на 2-3 разработчика, то любая структура будет работать. Если проект на 20-30 разработчиков — ситуация будет чуть иная.
> И проблемы это все нетехнические — машинам похеру на структуру кода. Это в основном проблемы коммуникации между людьми и задача управления сложностью.
>
> Любой успешный продукт довольно быстро начнет расти в плане количества людей, и проблемы коммуникаций будут увеличиваться как факториал количества участников.
> Во всяком случае, если не изолировать фичи. При разделении проекта на фичи ты будешь ошибаться и не один раз.
> Тем более на начальных этапах, когда не очень понятно, что проект из себя представляет и как оно должно быть.
> Главное, что если не пытаться и не пробовать, то ты быстро придешь к крайне неэффективному процессу разработки.

Данный скелетон демонстрирует, как можно организовать модульность в проекте на базе компонента Symfony Dependency Injection.

Здесь модуль — это неймспейс с классами и конфигами DI и роутинга.
Когда модули всё своё "носят" с собой, их легко переименовывать, перегруппировывать, анализировать и удалять.
Особенно удобно в этом случае использовать конфигурацию в формате PHP, тогда рефакторинг в IDE становится полностью автоматическим.

## Изменения относительно стандартного symfony/skeleton

1. Удалён `config/services.yaml`. Он не нужен, так как вендорные бандлы конфигурируются в `config/packages`, а модули проекта конфигурируются в своих `di.php`.
1. В `src/Kernel.php` прописан импорт `di.php` и `routing.php` из любых поддиректорий `src`.
1. Добавлен модуль `src/MyBusinessFeature`. Обратите внимание, что в `di.php` тоже прописан неймспейс модуля — благодаря этому PhpStorm будет переносить его вслед за классами при рефакторинге.
