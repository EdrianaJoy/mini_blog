import React from 'react';
import * as Dialog from '@radix-ui/react-dialog';
import * as DropdownMenu from '@radix-ui/react-dropdown-menu';
import { DashboardTabs } from './DashboardTabs'; // <-- make sure this path is correct

function UserActionsDropdown() {
  return (
    <DropdownMenu.Root>
      <DropdownMenu.Trigger className="bg-rose-500 text-white px-4 py-2 rounded">
        Actions
      </DropdownMenu.Trigger>

      <DropdownMenu.Portal>
        <DropdownMenu.Content
          className="min-w-[160px] bg-white rounded-xl shadow-lg p-2 space-y-2"
          sideOffset={5}
        >
          <DropdownMenu.Item className="px-3 py-2 hover:bg-rose-100 rounded cursor-pointer">
            Edit User
          </DropdownMenu.Item>
          <DropdownMenu.Item className="px-3 py-2 hover:bg-rose-100 rounded cursor-pointer">
            Delete User
          </DropdownMenu.Item>
        </DropdownMenu.Content>
      </DropdownMenu.Portal>
    </DropdownMenu.Root>
  );
}

export default function Dashboard() {
  const role = window.user?.role; // injected via Blade

  return (
    <div className="p-8 space-y-6">
      <h1 className="text-2xl font-bold text-rose-500">Admin Dashboard</h1>

      {/* Modal */}
      <Dialog.Root>
        <Dialog.Trigger className="bg-rose-500 text-white px-4 py-2 rounded">
          Open Modal
        </Dialog.Trigger>
        <Dialog.Portal>
          <Dialog.Overlay className="fixed inset-0 bg-black bg-opacity-50" />
          <Dialog.Content className="fixed p-6 bg-white rounded-xl top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
            <Dialog.Title className="text-lg font-bold">Welcome</Dialog.Title>
            <Dialog.Description>This is a Radix UI modal!</Dialog.Description>
            <Dialog.Close className="absolute top-2 right-2 text-gray-500">X</Dialog.Close>
          </Dialog.Content>
        </Dialog.Portal>
      </Dialog.Root>

      {/* Dropdown */}
      <UserActionsDropdown />

      {/* Tabs - only shown to admin or editor */}
      {(role === 'admin' || role === 'editor') && <DashboardTabs />}
    </div>
  );
}
export { DashboardTabs };
