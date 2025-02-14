import { create } from "zustand";
import { User } from "firebase/auth";

interface UserStore {
    user: User | null; 
    updateUser: (user: User | null) => void;
}

const useUserStore = create<UserStore>((set) => ({
    user: null,
    updateUser: (user) => set({ user }),
}));
  
export default useUserStore;