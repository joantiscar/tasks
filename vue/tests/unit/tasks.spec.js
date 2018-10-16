import { expect } from 'chai'
import moxios from 'moxios'
import { mount } from '@vue/test-utils'
import Tasks from '../../../resources/js/components/Tasks.vue'

describe('Tasks.vue', () => {
  it.only('contains_a_list_of_tasks', () => {
    beforeEach(function () {
      // import and pass your custom axios instance to this method
      moxios.install()
    })

    afterEach(function () {
      // import and pass your custom axios instance to this method
      moxios.uninstall()
    })

    const wrapper = mount(Tasks, {
      propsData: {
        tasks: [
          {
            id: 1,
            name: 'Comprar pa',
            completed: false
          },
          {
            id: 2,
            name: 'Comprar lejia',
            completed: true
          },
          {
            id: 3,
            name: 'Estudiar PHP',
            completed: true
          }
        ]
      }

    })
      const wrapper = mount(Tasks)
    console.log(wrapper.text())
    expect(wrapper.text()).contains('Comprar pa')
    expect(wrapper.text()).contains('Comprar lejia')
    expect(wrapper.text()).contains('Estudiar PHP')
    expect(wrapper.vm.dataTasks).to.have.lengthOf(3)
    expect(wrapper.vm.dataTasks[0].id).equals(1)
    expect(wrapper.vm.dataTasks[0].name).equals('Comprar pa')
    expect(wrapper.vm.dataTasks[0].completed).equals(false)
    expect(wrapper.vm.dataTasks[1].id).equals(2)
    expect(wrapper.vm.dataTasks[1].name).equals('Comprar lejia')
    expect(wrapper.vm.dataTasks[1].completed).equals(true)
    expect(wrapper.vm.dataTasks[2].id).equals(3)
    expect(wrapper.vm.dataTasks[2].name).equals('Estudiar PHP')
    expect(wrapper.vm.dataTasks[2].completed).equals(true)
  })
  it('contains_a_list_of_tasks', (done) => {
    moxios.stubRequest('/api/v1/tasks', {
      status: 200,
      response: [
        {
          id: 1,
          name: 'Comprar pa',
          completed: false
        },
        {
          id: 2,
          name: 'Comprar lejia',
          completed: true
        },
        {
          id: 3,
          name: 'Estudiar PHP',
          completed: true
        }
      ],

        moxios.wait(expect(wrapper.text()).contains('Comprar pa')
      expect(wrapper.text()).contains('Comprar lejia')
      expect(wrapper.text()).contains('Estudiar PHP')
      expect(wrapper.vm.dataTasks).to.have.lengthOf(3)
      expect(wrapper.vm.dataTasks[0].id).equals(1)
      expect(wrapper.vm.dataTasks[0].name).equals('Comprar pa')
      expect(wrapper.vm.dataTasks[0].completed).equals(false)
      expect(wrapper.vm.dataTasks[1].id).equals(2)
      expect(wrapper.vm.dataTasks[1].name).equals('Comprar lejia')
      expect(wrapper.vm.dataTasks[1].completed).equals(true)
      expect(wrapper.vm.dataTasks[2].id).equals(3)
      expect(wrapper.vm.dataTasks[2].name).equals('Estudiar PHP')
      expect(wrapper.vm.dataTasks[2].completed).equals(true))
    })
  })
  it.skip('shows_nothing_when_no_tasks_provided', () => {
    // expect(wrapper.text()).to.include(msg)
    // 1

    // 2
    const wrapper = mount(Tasks, {
      propsData: {
        tasks: [{ name: 'asa' }]
      }
    }) // <tasks></tasks>
    // 3
    console.log(wrapper.text())
  })
  it('todo2', () => {

  })
})
