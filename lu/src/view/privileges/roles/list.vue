<template>
<div id="privileges-users-list">
  <Row type="flex" justify="end" class="code-row-bg" :gutter="16">
    <Col span="3">
    <Input icon="search" placeholder="请输入角色名称..." v-model="searchForm.name" />
    </Col>
    <Col span="2">
    <Button type="primary" icon="ios-search" @click="getTableDataExcute()">Search</Button>
    </Col>
    <Col span="2">
    <Button type="success" icon="plus" @click="addBtn()">Add</Button>
    </Col>
  </Row>
  <br>

  <Row>
    <div class="demo-spin-container" v-if="tableLoading">
      <Spin fix>
        <Icon type="load-c" size=18 class="spin-icon-load"></Icon>
        <div>加载中...</div>
      </Spin>
    </div>
    <Table border :columns="columns" :data="dataList"></Table>
  </Row>

  <Modal v-model="addEditRoleModal.show" :closable='false' :mask-closable=false :width="500">
    <h3 slot="header" style="color:#2D8CF0">编辑角色</h3>
    <Form ref="addEditRoleForm" :model="addEditRoleForm" :label-width="100" label-position="right" :rules="ruleAddEditRole">
      <FormItem label="角色名称" prop="name">
        <Input v-model="addEditRoleForm.name" placeholder="请输角色名称"></Input>
      </FormItem>
      <FormItem label="看守器" prop="guard_name">
        <Input v-model="addEditRoleForm.guard_name" placeholder="请输入看守器"></Input>
      </FormItem>
      <FormItem label="角色描述" prop="description">
        <Input v-model="addEditRoleForm.description" placeholder="请输入角色描述"></Input>
      </FormItem>

    </Form>
    <div slot="footer">
      <Button @click="cancelEditPass">取消</Button>
      <Button type="primary" @click="addEditRoleExcute" :loading="addEditRoleModal.saveLoading">保存</Button>
    </div>
  </Modal>
  <Modal v-model="permissionModal.show" :closable='false' :mask-closable=false width="1000">
    <h3 slot="header" style="color:#2D8CF0">分配权限</h3>
    <Transfer v-if="permissionModal.show" :data="permissionModal.allPermissions" :target-keys="permissionModal.hasPermissions" :render-format="renderFormat" :operations="['移除权限','添加权限']" :list-style="permissionModal.listStyle" filterable @on-change="handleTransferChange">
    </Transfer>
    <div slot="footer">
      <Button type="text" @click="cancelPermissionModal">取消</Button>
      <Button type="primary" @click="giveRolePermissionExcute">保存
                </Button>
    </div>
  </Modal>
</div>
</template>


<script>
import {
  getAllPermission,
  getTableData,
  addEditRole,
  getRolePermissions,
  giveRolePermission,
  deleteRole
} from '@/api/roles'

export default {
  data() {
    return {
      searchForm: {},
      tableLoading: false,
      dataList: [],
      modalHeadImage: {
        show: false,
        url: null
      },
      addEditRoleModal: {
        show: false,
        saveLoading: false,
      },
      permissionModal: {
        id: 0,
        allPermissions: [],
        hasPermissions: [],
        show: false,
        saveLoading: false,
        listStyle: {
          width: '400px',
          height: '400px'
        }
      },
      ruleAddEditRole: {
        name: [{
          required: true,
          message: '请填写角色限名称',
          trigger: 'blur'
        }],
        guard_name: [{
          required: true,
          message: '请填写看守器',
          trigger: 'blur'
        }],
      },
      addEditRoleForm: {
        id: 0,
        name: '',
        guard_name: '',
        description: ''
      },
      columns: [{
          title: 'ID',
          key: 'id',
          sortable: true,
          width: 100
        },
        {
          title: '角色限名称',
          key: 'name'
        },
        {
          title: '角色看守器',
          key: 'guard_name'
        },
        {
          title: '角色描述',
          key: 'description'
        },
        {
          title: '创建时间',
          key: 'created_at',
          sortable: true,
        },
        {
          title: '更新时间',
          key: 'created_at'
        },
        {
          title: '操作',
          render: (h, params) => {
            let t = this
            return h('div', [
              h('Button', {
                props: {
                  type: 'success',
                  size: 'small'
                },
                style: {
                  marginRight: '5px'
                },
                on: {
                  click: () => {
                    t.addEditRoleForm = t.dataList[params.index]
                    t.addEditRoleModal.show = true
                  }
                }

              }, 'Edit'),
              h('Button', {
                props: {
                  type: 'info',
                  size: 'small'
                },
                style: {
                  marginRight: '5px'
                },
                on: {
                  click: () => {
                    t.getRolePermissionsExcute(params.row.id)
                    t.permissionModal.show = true
                    t.permissionModal.id = params.row.id
                  }
                }

              }, '权限'),

              h('Poptip', {
                props: {
                  confirm: true,
                  title: '您确定要删除「' + params.row.name + '」角色？',
                  transfer: true
                },
                on: {
                  'on-ok': () => {
                    t.deleteRoleExcute(params.row.id, params.index)
                  }
                }
              }, [
                h('Button', {
                  style: {
                    margin: '0 5px'
                  },
                  props: {
                    type: 'error',
                    size: 'small',
                    placement: 'top'
                  }
                }, '删除'),
              ])
            ])
          },
        },
      ]
    }
  },

  created() {
    let t = this
    t.getTableDataExcute()
    t.getAllPermissionExcute()
    t.addEditRoleExcute()
  },
  methods: {
    renderFormat(item) {
      return item.label + '「' + item.description + '」'
    },
    cancelPermissionModal() {
      let t = this
      t.permissionModal.show = false
      t.permissionModal.saveLoading = false
    },
    getAllPermissionExcute() {
      let t = this
      getAllPermission().then(res => {
        t.permissionModal.allPermissions = res.data
      }, function(error) {})
    },
    getTableDataExcute() {
      let t = this
      t.tableLoading = true
      getTableData(t.searchForm).then(res => {
        const response_data = res.data
        t.dataList = response_data
        t.tableLoading = false
      }, function(error) {
        t.tableLoading = false
      })
    },
    addEditRoleExcute() {
      let t = this
      t.$refs.addEditRoleForm.validate((valid) => {
        if (valid) {
          t.addEditRoleModal.saveLoading = true

          addEditRole(t.addEditRoleForm).then(res => {
            t.$Notice.success({
              title: res.message
            })
            t.getTableDataExcute()
            t.addEditRoleModal.saveLoading = false
            t.addEditRoleModal.show = false
          }, function(error) {
            t.addEditRoleModal.saveLoading = false
          })
        }
      })
    },
    handleTransferChange(newTargetKeys) {
      this.permissionModal.hasPermissions = newTargetKeys
    },
    getRolePermissionsExcute(id) {
      let t = this;
      getRolePermissions(id).then(res => {
        t.permissionModal.hasPermissions = res.data
      })
    },
    giveRolePermissionExcute() {
      let t = this
      giveRolePermission(t.permissionModal.id, t.permissionModal.hasPermissions).then(res => {
        t.$Notice.success({
          title: res.message
        })
        t.permissionModal.show = false
      })
    },
    cancelEditPass() {
      let t = this
      t.addEditRoleModal.show = false
      t.addEditRoleModal.saveLoading = false
      t.cleanModal()
    },
    cleanModal() {
      let t = this
      t.addEditRoleForm = {
        id: 0,
        name: '',
        guard_name: '',
        description: ''
      }
    },
    addBtn() {
      this.cleanModal()
      this.addEditRoleModal.show = true
    },
    deleteRoleExcute(role, key) {
      let t = this
      deleteRole(role).then(res => {
        t.dataList.splice(key, 1)
        t.$Notice.success({
          title: res.message
        })
      })
    },
  },
}
</script>
