import { create } from "zustand";
import { getAuth, onAuthStateChanged, User } from "firebase/auth";
import { firebase } from "../services/firebaseConfig";

interface UserState {
  user: User | null;
  verifyingAuth: boolean;
  setUser: (user: User | null) => void;
  checkAuth: () => void;
}

const auth = getAuth(firebase);

const useUserStore = create<UserState>((set) => ({
  user: null,
  verifyingAuth: true,
  setUser: (user) => set({ user, verifyingAuth: false }),
  checkAuth: () => {
    onAuthStateChanged(auth, (user) => {
      set({ user, verifyingAuth: false });
    });
  },
}));

export default useUserStore;
