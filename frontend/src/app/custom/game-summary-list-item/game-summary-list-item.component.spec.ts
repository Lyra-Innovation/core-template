import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { GameSummaryListItemComponent } from './game-summary-list-item.component';

describe('GameSummaryListItemComponent', () => {
  let component: GameSummaryListItemComponent;
  let fixture: ComponentFixture<GameSummaryListItemComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ GameSummaryListItemComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(GameSummaryListItemComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
