<template>
  <div>
    <arbitrary-position :item="items.title" @update="items.title = $event">
      Vasya Pupkin
    </arbitrary-position>

    <arbitrary-position :item="items.counter" @update="items.counter = $event">
      500 руб.
    </arbitrary-position>

    <arbitrary-position :item="items.attacment" @update="items.attacment = $event">
      <v-img src="https://telegraf.com.ua/files/2018/06/fd8b0f77d767f1f6640afba6916ff67c_XL.jpg"></v-img>
    </arbitrary-position>

    Title: {{items.title.x}} | {{items.title.y}}<br>
    Counter: {{items.counter.x}} | {{items.counter.y}}<br>
    Attacment: {{items.attacment.x}} | {{items.attacment.y}}<br>
  </div>
</template>

<script>
  import ArbitraryPosition from '../components/ArbitraryPosition'
  import AnimateText from '../components/Animate'

  export default {
    components: {
      ArbitraryPosition, AnimateText
    },
    data() {
      return {
        items: {
          title: {
            id: "title",
            x: 406,
            y: 250,
            scaleX: 1,
            scaleY: 1,
            width: 200,
            height: 100,
            angle: 0,
            classPrefix: "tr2",
            text: "Scale Enabled",
          },
          attacment: {
            id: "title",
            x: 0,
            y: 0,
            scaleX: 1,
            scaleY: 1,
            width: 200,
            height: 100,
            angle: 0,
            classPrefix: "tr2",
            text: "Scale Enabled",
          },
          counter: {
            id: "title",
            x: 500,
            y: 500,
            scaleX: 1,
            scaleY: 1,
            width: 200,
            height: 100,
            angle: 0,
            classPrefix: "tr2",
            text: "Scale Enabled",
          },
        },
      }
    },
  }
</script>

<style>
  .tr-transform__content {
    user-select: none;
  }

  .tr-transform__rotator {
    top: -45px;
    left: calc(50% - 7px);
  }

  .tr-transform__rotator,
  .tr-transform__scale-point {
    background: #fff;
    width: 15px;
    height: 15px;
    border-radius: 50%;
    position: absolute;
    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(0, 0, 0, 0.1);
    cursor: pointer;
  }

  .tr-transform__rotator:hover,
  .tr-transform__scale-point:hover {
    background: #F1F5F8;
  }

  .tr-transform__rotator:active,
  .tr-transform__scale-point:active {
    background: #DAE1E7;
  }

  .tr-transform__scale-point {

  }

  .tr-transform__scale-point--tl {
    top: -7px;
    left: -7px;
  }

  .tr-transform__scale-point--ml {
    top: calc(50% - 7px);
    left: -7px;
  }

  .tr-transform__scale-point--tr {
    left: calc(100% - 7px);
    top: -7px;
  }

  .tr-transform__scale-point--tm {
    left: calc(50% - 7px);
    top: -7px;
  }

  .tr-transform__scale-point--mr {
    left: calc(100% - 7px);
    top: calc(50% - 7px);
  }

  .tr-transform__scale-point--bl {
    left: -7px;
    top: calc(100% - 7px);
  }

  .tr-transform__scale-point--bm {
    left: calc(50% - 7px);
    top: calc(100% - 7px);
  }

  .tr-transform__scale-point--br {
    left: calc(100% - 7px);
    top: calc(100% - 7px);
  }
</style>
