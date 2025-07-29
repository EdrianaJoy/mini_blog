import { useState, useEffect } from 'react';
import * as Tabs from '@radix-ui/react-tabs';

function DashboardTabs() {
  const [users, setUsers] = useState([]);
  const [posts, setPosts] = useState([]);

  useEffect(() => {
    fetch('/api/users')
      .then((res) => res.json())
      .then(setUsers)
      .catch(console.error);

    fetch('/api/posts')
      .then((res) => res.json())
      .then(setPosts)
      .catch(console.error);
  }, []);

  const handleDeleteUser = (id) => {
    fetch(`/api/users/${id}`, { method: 'DELETE' })
      .then((res) => res.ok && setUsers(users.filter((u) => u.id !== id)));
  };

  const handleDeletePost = (id) => {
    fetch(`/api/posts/${id}`, { method: 'DELETE' })
      .then((res) => res.ok && setPosts(posts.filter((p) => p.id !== id)));
  };

  return (
    <Tabs.Root defaultValue="users" className="w-full mt-8">
      {/* Tab Triggers */}
      <Tabs.List className="flex space-x-4 border-b border-rose-200 pb-2 mb-4">
        <Tabs.Trigger value="users" className="px-4 py-2 text-rose-600 font-semibold hover:bg-rose-100 rounded">
          Users
        </Tabs.Trigger>
        <Tabs.Trigger value="posts" className="px-4 py-2 text-rose-600 font-semibold hover:bg-rose-100 rounded">
          Posts
        </Tabs.Trigger>
      </Tabs.List>

      {/* Users Tab */}
      <Tabs.Content value="users">
        <div className="p-4 border rounded-xl bg-white shadow">
          <h2 className="text-lg font-bold mb-4">User Management</h2>
          <ul className="space-y-2">
            {users.map((user) => (
              <li key={user.id} className="p-2 border rounded flex justify-between items-center">
                <span>{user.name} - {user.email}</span>
                <button
                  onClick={() => handleDeleteUser(user.id)}
                  className="text-sm text-red-600 hover:underline"
                >
                  Delete
                </button>
              </li>
            ))}
          </ul>
        </div>
      </Tabs.Content>

      {/* Posts Tab */}
      <Tabs.Content value="posts">
        <div className="p-4 border rounded-xl bg-white shadow">
          <h2 className="text-lg font-bold mb-4">Post Management</h2>
          <ul className="space-y-2">
            {posts.map((post) => (
              <li key={post.id} className="p-2 border rounded flex justify-between items-center">
                <span>{post.title}</span>
                <button
                  onClick={() => handleDeletePost(post.id)}
                  className="text-sm text-red-600 hover:underline"
                >
                  Delete
                </button>
              </li>
            ))}
          </ul>
        </div>
      </Tabs.Content>
    </Tabs.Root>
  );
}

export { DashboardTabs };
