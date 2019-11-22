<template>
  <div class="workspace" ref="workspace">
    <FreeTransform
      selectOn="dblclick"
      @dblclick="selected = !selected, $store.dispatch('positionChangeMode', false)"
      :selected="selected || positionChangeMode"
      :x="element.x"
      :y="element.y"
      :scale-x="element.scaleX"
      :scale-y="element.scaleY"
      :width="element.width"
      :height="element.height"
      :angle="element.angle"
      :offset-x="offsetX"
      :offset-y="offsetY"
      :disable-scale="element.disableScale === true"
      :scale-from-center="true"
      @update="update($event)"
    >
      <div 
        :style="getElementStyles(element)"
      >
        <slot></slot>
      </div>
    </FreeTransform>
  </div>
</template>

<script>
  import FreeTransform from 'vue-free-transform'

  export default {
    components: {
      FreeTransform
    },
    props: {
      item: {
        type: Object,
        required: true
      },
      zIndex: {
        type: Number,
        default: 100
      }
    },
    data () {
      return {
        selected: false,
        element: this.item,
        offsetX: 0,
        offsetY: 0
      }
    },
    computed: {
      positionChangeMode: function () {
        return this.$store.state.positionChangeMode
      },
    },
    mounted () {
      this.offsetX = this.$refs.workspace.offsetLeft
      this.offsetY = this.$refs.workspace.offsetTop
    },
    methods: {
      update (payload) {
        this.element = {...this.element, ...payload}
        this.$emit('update', this.element)
      },
      getElementStyles (element) {
        const styles = element.styles ? element.styles : {}
        return {
          width: `${element.width}px`,
          height: `${element.height}px`,
          ...styles
        }
      }
    }
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

  /* .tr-transform__controls {
    width: 15%!important;
  } */

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
