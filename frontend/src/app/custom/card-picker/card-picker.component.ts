import { Component, Input, QueryList, ViewChildren } from '@angular/core';
import { BaseComponent } from 'renderer';
import { DialogLauncherComponent } from 'renderer';
import { RootState, SetVariable } from 'presenter';
import { Store } from '@ngrx/store';
import { RequestState, NavigateRoute } from 'projects/presenter/src/lib/state';

@Component({
  selector: 'act-card-picker',
  templateUrl: './card-picker.component.html',
  styleUrls: ['./card-picker.component.scss']
})
export class CardPickerComponent extends BaseComponent {
  @ViewChildren('dialog')
  dialogLauncher: QueryList<DialogLauncherComponent>;

  @Input()
  games: Array<string>;

  @Input()
  picks: Array<{ id: number; type: string; name: string; image: string }>;

  placeholders = ['/assets/carta1.png', '/assets/carta2.png'];

  showCards = false;

  constructor(protected store: Store<RootState>) {
    super();
  }

  pickCard(index: number) {
    this.closeDialog(index, null);
    this.store.dispatch(
      new SetVariable({
        name: 'pickedItemId',
        value: this.picks[index].id
      })
    );
    this.store.dispatch(
      new SetVariable({
        name: 'pickedItemType',
        value: this.picks[index].type
      })
    );
    this.store.dispatch(
      new SetVariable({
        name: 'pickedItemName',
        value: this.picks[index].name
      })
    );
    this.store.dispatch(
      new SetVariable({
        name: 'pickedItemImage',
        value: this.picks[index].image
      })
    );
    this.store.dispatch(
      new SetVariable({
        name: 'pickedGame',
        value: this.games[index]
      })
    );
    this.store.dispatch(new NavigateRoute({ route: '/game/:$me/play' }));
  }

  closeDialog(index, $event) {
    this.dialogLauncher.toArray()[index].dialogRef.close();
  }
}
