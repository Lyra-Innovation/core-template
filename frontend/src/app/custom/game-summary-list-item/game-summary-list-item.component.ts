import { Component, ChangeDetectionStrategy, Input } from '@angular/core';
import { BaseComponent } from 'renderer';
import { Router } from '@angular/router';
import { Store } from '@ngrx/store';
import { RootState, NavigateRoute, ShowNotification } from 'presenter';

@Component({
  selector: 'act-game-summary-list-item',
  templateUrl: './game-summary-list-item.component.html',
  styleUrls: ['./game-summary-list-item.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush
})
export class GameSummaryListItemComponent extends BaseComponent {
  @Input()
  id: string;

  @Input()
  name: string;

  @Input()
  status: string;

  @Input()
  allies: string;

  @Input()
  competences: string;

  @Input()
  resources: string;

  constructor(protected store: Store<RootState>) {
    super();
  }

  beginValidation() {
    if (this.status !== 'views.game.states.pending-init') {
      this.store.dispatch(
        new NavigateRoute({ route: `/game/${this.id}/home` })
      );
    } else {
      this.store.dispatch(
        new ShowNotification({
          message: 'views.dynamizer.pending-init-validation-disabled'
        })
      );
    }
  }
}
