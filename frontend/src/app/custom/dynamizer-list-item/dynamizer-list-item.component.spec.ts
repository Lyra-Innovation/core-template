import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DynamizerListItemComponent } from './dynamizer-list-item.component';

describe('DynamizerListItemComponent', () => {
  let component: DynamizerListItemComponent;
  let fixture: ComponentFixture<DynamizerListItemComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DynamizerListItemComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DynamizerListItemComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
