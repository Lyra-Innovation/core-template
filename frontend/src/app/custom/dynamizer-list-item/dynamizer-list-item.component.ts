import {
  Component,
  ChangeDetectionStrategy,
  Input
} from '@angular/core';
import { BaseComponent } from 'renderer';

@Component({
  selector: 'act-dynamizer-list-item',
  templateUrl: './dynamizer-list-item.component.html',
  styleUrls: ['./dynamizer-list-item.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush
})
export class DynamizerListItemComponent extends BaseComponent {
  @Input()
  name: string;

  @Input()
  games: number;

  constructor() {
    super();
  }

  protected getCssClasses() {
    return super.getCssClasses() + ' renderer-list-item';
  }
}
