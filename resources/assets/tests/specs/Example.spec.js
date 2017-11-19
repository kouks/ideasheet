import Vue from 'vue'
import { expect } from 'chai'
import Example from '@/components/Example.vue'

Vue.config.productionTip = false

describe('Example.vue', () => {
  it('should print hello world.', () => {
    const Compoment = Vue.extend(Example)
    const vm = new Compoment().$mount()

    expect(vm.$el.querySelector('div').textContent).to.equal('Hello')
  })
})
