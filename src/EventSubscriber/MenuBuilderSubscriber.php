<?php

namespace App\EventSubscriber;

use KevinPapst\AdminLTEBundle\Event\SidebarMenuEvent;
use KevinPapst\AdminLTEBundle\Model\MenuItemModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MenuBuilderSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            SidebarMenuEvent::class => ['onSetupMenu', 100],
        ];
    }

    public function onSetupMenu(SidebarMenuEvent $event)
    {
        $fin = new MenuItemModel('fin', 'Podsumowanie', 'worker_home', [], 'fas fa-chart-line');

        $incomes = new MenuItemModel('inc', 'Przychody', 'income_index', [], 'fas fa-euro-sign');
        $incomes->addChild(new MenuItemModel('inc_sum', 'Lista przychodów', 'income_index', [], 'fas fa-euro-sign'));
        $incomes->addChild(new MenuItemModel('inc_new', 'Dodaj przychód', 'income_new', [], 'fas fa-plus'));

        $outcomes = new MenuItemModel('out', 'Koszty', 'outcome_index', [], 'fas fa-dollar-sign');
        $outcomes->addChild(new MenuItemModel('out_sum', 'Lista kosztów', 'outcome_index', [], 'fas fa-dollar-sign'));
        $outcomes->addChild(new MenuItemModel('out_new', 'Dodaj koszt', 'outcome_new', [], 'fas fa-minus'));

        $categories = new MenuItemModel('cat', 'Kategorie', 'category_index', [], 'fas fa-barcode');
        $categories->addChild(new MenuItemModel('cat_sum', 'Lista kategorii', 'category_index', [], 'fas fa-barcode'));
        $categories->addChild(new MenuItemModel('cat_new', 'Dodaj kategorię', 'category_new', [], 'fas fa-plus'));

        $accounts = new MenuItemModel('acc', 'Konta', 'account_index', [], 'fas fa-piggy-bank');
        $accounts->addChild(new MenuItemModel('acc_sum', 'Lista kont', 'account_index', [], 'fas fa-piggy-bank'));
        $accounts->addChild(new MenuItemModel('acc_new', 'Dodaj konto', 'account_new', [], 'fas fa-plus'));

        $event->addItem($fin);
        $event->addItem($incomes);
        $event->addItem($outcomes);
        $event->addItem($categories);
        $event->addItem($accounts);

        $this->activateByRoute(
            $event->getRequest()->get('_route'),
            $event->getItems()
        );
    }

    /**
     * @param string $route
     * @param MenuItemModel[] $items
     */
    protected function activateByRoute($route, $items)
    {
        foreach ($items as $item) {
            if ($item->hasChildren()) {
                $this->activateByRoute($route, $item->getChildren());
            } elseif ($item->getRoute() == $route) {
                $item->setIsActive(true);
            }
        }
    }
}