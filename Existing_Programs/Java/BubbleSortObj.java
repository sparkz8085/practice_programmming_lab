import java.util.*;
public class BubbleSortObj
{
	int arr[]=new int[1000];
	int size;
	BubbleSortObj(int x)
	{
		size=x;
	}
	void GetVal()
	{
		Scanner sc= new Scanner(System.in);
		for(int i=0; i<size; i++)
		{
			System.out.println("Enter value = ");
			arr[i]=sc.nextInt();
		}
	}
	void Display()
	{
		for(int i=0; i<size; i++)
		{
			System.out.print(arr[i]+", ");
		}
	}
	void Sort()
	{
		for(int i=0; i<size; i++)
		{
			for(int j= 0; j<size-i-1; j++)
			{
				if(arr[j]>arr[j+1])
				{
					int temp=arr[j];
					arr[j]=arr[j+1];
					arr[j+1]=temp;
				}
			}
		}
	}
	public static void main(String args[])
	{
		Scanner ab= new Scanner(System.in);
		System.out.println("Enter Size of Array ");
		int len= ab.nextInt();
		BubbleSortObj abc= new BubbleSortObj(len);		
		abc.GetVal();
		System.out.println("Entered Values = ");
		abc.Display();
		abc.Sort();
		System.out.println("\nsorted Values = ");
		abc.Display();
	}
}


