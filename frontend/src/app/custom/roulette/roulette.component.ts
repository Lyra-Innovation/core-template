import { Component, OnInit, ChangeDetectionStrategy, Input, Output, EventEmitter } from '@angular/core';

@Component({
  selector: 'act-roulette',
  templateUrl: './roulette.component.html',
  styleUrls: ['./roulette.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush
})
export class RouletteComponent implements OnInit {

  constructor() { }

  ngOnInit() {
  }

}
