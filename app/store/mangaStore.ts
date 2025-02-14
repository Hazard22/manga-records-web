import { create } from "zustand";
import { Manga } from "../types/manga";

interface MangaState {
  manga: Manga | null;
  setManga: (manga: Manga | null) => void;
}


const useMangaStore = create<MangaState>((set) => ({
  manga: null,
  setManga: (manga) => set({ manga }),
}));

export default useMangaStore;
