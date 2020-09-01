<?php

declare(strict_types=1);

namespace Pehapkari\Blog\Tests\Posts\Year2017\NetteConfigObjects\Forms;

use Nette\Application\UI\Form;
use Nette\DI\Container;
use Nette\Forms\Controls\SelectBox;
use Pehapkari\Blog\Posts\Year2017\NetteConfigObjects\Forms\InvoiceFormNew;
use Pehapkari\Blog\Posts\Year2017\NetteConfigObjects\Forms\InvoiceFormNewFactoryInterface;
use Pehapkari\Blog\Posts\Year2017\NetteConfigObjects\Forms\InvoiceFormOld;
use Pehapkari\Blog\Posts\Year2017\NetteConfigObjects\Forms\InvoiceFormOldFactory;
use Pehapkari\Blog\Tests\Posts\Year2017\NetteConfigObjects\ContainerFactory;
use PHPUnit\Framework\TestCase;

final class InvoiceFormTest extends TestCase
{
    private Container $container;

    protected function setUp(): void
    {
        $this->container = (new ContainerFactory())->create();
    }

    public function testOldForm(): void
    {
        /** @var InvoiceFormOldFactory $factory */
        $factory = $this->container->getByType(InvoiceFormOldFactory::class);
        $control = $factory->create();
        /** @var Form $form */
        $form = $control->getComponent('invoiceForm');
        /** @var SelectBox $maturity */
        $maturity = $form->getComponent('maturity');

        $this->assertInstanceOf(InvoiceFormOld::class, $control);
        $this->assertInstanceOf(Form::class, $form);
        $this->assertSame(7, $maturity->getValue());
    }

    public function testNewForm(): void
    {
        /** @var InvoiceFormNewFactoryInterface $factory */
        $factory = $this->container->getByType(InvoiceFormNewFactoryInterface::class);
        $control = $factory->create();
        /** @var Form $form */
        $form = $control->getComponent('invoiceForm');
        /** @var SelectBox $maturity */
        $maturity = $form->getComponent('maturity');

        $this->assertInstanceOf(InvoiceFormNew::class, $control);
        $this->assertInstanceOf(Form::class, $form);
        $this->assertSame(7, $maturity->getValue());
    }
}
